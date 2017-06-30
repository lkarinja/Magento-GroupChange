<?php

namespace PlymDesign\GroupChange\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

use Magento\Framework\App\ObjectManager;

use Psr\Log\LoggerInterface;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

use Magento\Framework\App\ResourceConnection;

use Magento\Framework\Message\ManagerInterface;

class GroupChangeObserver implements ObserverInterface
{

	/**
	 * Determine whether to write to debug log
	 *
	 * @var bool
	 */
	private $use_debug = true;

	/**
	 * SKU of the Membership Item
	 *
	 * @var string
	 */
	private $membershipItemSKU = "Membership";

	/**
	 * Group ID for the Member Group
	 *
	 * @var int
	 */
	private $memberGroupID = 4;

	/**
	 * Group ID for the Non-Member Group
	 *
	 * @var int
	 */
	private $nonMemberGroupID = 1;

	/**
	 * Logger Interface for writing to log files in \var\log\
	 *
	 @var LoggerInterface
	 */
	protected $logger;

	/**
	 * Customer Interface for getting details about a Customer
	 *
	 * @var CustomerRepositoryInterface
	 */
	protected $customerRepositoryInterface;

	/**
	 * Order Interface for getting details about an order
	 *
	 * @var OrderRepositoryInterface
	 */
	protected $orderRepositoryInterface;

	/**
	 * Resource Connection for access to the Magento Database
	 *
	 * @var ResourceConnection
	 */
	protected $resourceConnection;

	/**
	 * Manager Interface for displaying messages
	 *
	 * @var ManagerInterface
	 */
	protected $managerInterface;

	/**
	 * Constructor for setting interfaces
	 *
	 * @param LoggerInterface $loggerInterface Logger Interface to be referenced and used
	 * @param CustomerRepositoryInterface $customerRepositoryInterface Customer Interface to be referenced and used
	 * @param OrderRepositoryInterface $orderRepositoryInterface Order Interface to be referenced and used
	 * @param ResourceConnection $resourceConnection Connection to Magento Database to be referenced and used
	 * @param ManagerInterface $managerInterface Manager Interface to be referenced and used
	 *
	 * @return void
	 */
	public function __construct(
		LoggerInterface $loggerInterface,
		CustomerRepositoryInterface $customerRepositoryInterface,
		OrderRepositoryInterface $orderRepositoryInterface,
		ResourceConnection $resourceConnection,
		ManagerInterface $managerInterface
	){
		$this->logger = $loggerInterface;
		$this->customerRepositoryInterface = $customerRepositoryInterface;
		$this->orderRepositoryInterface = $orderRepositoryInterface;
		$this->resourceConnection = $resourceConnection;
		$this->managerInterface = $managerInterface;
	}

	/**
	 * Method called when event checkout_onepage_controller_success_action is triggered
	 *
	 * Determines if a customer's order contains a Membership Item
	 * If so, put them in the Member Group
	 *
	 * @param Observer $observer Observer object passed to be used for getting details on Order
	 * 
	 * @return void
	 */
    public function execute(Observer $observer)
    {
		//Write to Debug Log
        $this->debug('Observer GroupChangeObserver executing');

		//Get Order ID associated with the observed event
        $orderId = $observer->getEvent()->getOrderIds();

		//Get Order Details associated with the Order ID
		$order = $this->orderRepositoryInterface->get(end($orderId));

		//Get Customer ID associated with the Order Details
		$customerId = $order->getCustomerId();

		//If Customer exists
		if($customerId)
		{
			//Get Customer Details associated with the Customer ID
			$customer = $this->customerRepositoryInterface->getById($customerId);

			//Get customer's current Group ID
			$groupId = $customer->getGroupId();

			//If the customer is in the Non-Member Group...
			if ($groupId == $this->nonMemberGroupID)
			{
				//Get all items in the Order
				$items = $order->getAllItems();

				//For all items in the Order...
				foreach ($items as $item)
				{
					//Get the SKU of the Item
					$sku = $item->getSku();

					//If the SKU matches the SKU for the Membership Item
					if ($sku == $this->membershipItemSKU)
					{
						//Get the current time as a timestamp
						$timestamp = strtotime('NOW');

						//Calculate the date 365 days past the current date
						$expiration = $timestamp + (365 * 24 * 60 * 60);

						//Format the expiration timestamp into a human readable format
						$expirationDateTime = new \DateTime("@$expiration");
						$time = $expirationDateTime->format('Y-m-d H:i:s');

						//Query the database and update the records for membership_expiration_date of the user
						$sql = 'UPDATE customer_entity SET membership_expiration_date = "' . $time . '" WHERE entity_id = ' . $customerId;
						$this->querySql($sql);

						//Set the customer's Group ID to the ID of the Member Group
						$customer->setGroupId($this->memberGroupID);

						//Finalize changes to the customer to the database
						$this->customerRepositoryInterface->save($customer);

						//Alert customer that they have successfully purchased a Membership
						$this->managerInterface->addSuccess(__("Membership has been purchased successfully"));

						$this->debug('Set customer with ID ' . $customerId . ' to membership group and set expiration time to ' . $time);
					}
				}
			}
		}
    }

	/**
	 * Method for querying a SQL statement
	 *
	 * Gets a connection to the Magento Database to allow direct queries to the database
	 *
	 * @param string $query The SQL query to execute
	 *
	 * @return void
	 */
	protected function querySql($query)
	{
		//Get a connection to the Magento Database
		$connection = $this->resourceConnection->getConnection();
		//If the SQL is a SELECT statement
		if(0 === stripos($query, 'select'))
		{
			//Return the resutling query
			return $connection->fetchAll($query);
		}else{
			//Query the provided SQL
			$connection->query($query);
		}
	}

	/**
	 * Method for writing to /var/log/debug.log
	 *
	 * If and only if $use_debug is true, write to log
	 *
	 * @param string $data Data to write to log
	 *
	 * @return bool true if data was logged, false if data was not logged
	 */
	private function debug($data){
		if($this->use_debug == true){
			$this->logger->debug($data);
			return true;
		}else{
			return false;
		}
	}
}