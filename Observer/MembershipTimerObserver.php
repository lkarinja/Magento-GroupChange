<?php
/*
Copyright © 2017 Leejae Karinja

This file is part of GroupChange.

GroupChange is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

GroupChange is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with GroupChange.  If not, see <http://www.gnu.org/licenses/>.
*/
namespace PlymDesign\GroupChange\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

use Magento\Framework\App\ObjectManager;

use Psr\Log\LoggerInterface;

use Magento\Customer\Api\CustomerRepositoryInterface;

use Magento\Framework\App\ResourceConnection;

use Magento\Customer\Model\Session;

use Magento\Framework\Message\ManagerInterface;

class MembershipTimerObserver implements ObserverInterface
{

	/**
	 * Determine whether to write to debug log
	 *
	 * @var bool
	 */
	private $use_debug = true;

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
	 * @var LoggerInterface
	 */
	protected $logger;

	/**
	 * Customer Interface for getting details about a Customer
	 *
	 * @var CustomerRepositoryInterface
	 */
	protected $customerRepositoryInterface;

	/**
	 * Resource Connection for access to the Magento Database
	 *
	 * @var ResourceConnection
	 */
	protected $resourceConnection;

	/**
	 * Customer Session for getting information about the customer
	 *
	 * @var Session
	 */
	protected $session;

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
	 * @param ResourceConnection $resourceConnection Connection to Magento Database to be referenced and used
	 * @param Session $session Customer Session to be referenced and used
	 * @param ManagerInterface $managerInterface Manager Interface to be referenced and used
	 *
	 * @return void
	 */
	public function __construct(
		LoggerInterface $loggerInterface,
		CustomerRepositoryInterface $customerRepositoryInterface,
		ResourceConnection $resourceConnection,
		Session $session,
		ManagerInterface $managerInterface
	){
		$this->logger = $loggerInterface;
		$this->customerRepositoryInterface = $customerRepositoryInterface;
		$this->resourceConnection = $resourceConnection;
		$this->session = $session;
		$this->managerInterface = $managerInterface;
	}

	/**
	 * Method called when event checkout_cart_product_add_after is triggered
	 *
	 * Determines if a customer's membership_expiration_date has expired relative to the current server time
	 * If so, remove them from the Member Group
	 *
	 * @param Observer $observer Observer object passed to be used for getting details on Customer
	 * 
	 * @return void
	 */
    public function execute(Observer $observer)
    {
		//Write to Debug Log
        $this->debug('Observer MembershipTimerObserver executing');

		//Get Customer ID associated with the current Session
		$customerId = $this->session->getCustomer()->getId();

		//If Customer exists
		if($customerId)
		{
			//Get Customer Details associated with the Customer ID
			$customer = $this->customerRepositoryInterface->getById($customerId);

			//Get customer's current Group ID
			$groupId = $customer->getGroupId();

			//If the customer is in the Member Group...
			if ($groupId == $this->memberGroupID)
			{
				//Get the current time as a timestamp
				$timestamp = strtotime('NOW');

				//Query the database to find the membership_expiration_date for the given customer
				$sql = 'SELECT membership_expiration_date FROM customer_entity WHERE entity_id = ' . $customerId;
				$dateData = $this->querySql($sql);

				//Convert the readable date and time to a timestamp
				$date = strtotime($dateData[0]['membership_expiration_date']);

				//If the current time is past the time of expiration
				if($date < $timestamp)
				{
					//Set the customer's Group ID to the ID of the Non-Member Group
					$customer->setGroupId($this->nonMemberGroupID);

					//Save the modified details of the customer
					$this->customerRepositoryInterface->save($customer);

					//Query the database and update the records for membership_expiration_date of the user
					$sql = 'UPDATE customer_entity SET membership_expiration_date = NULL WHERE entity_id = ' . $customerId;
					$this->querySql($sql);

					//Alert customer that their membership has expired
					$this->managerInterface->addNotice(__("Your Membership has expired, so you will nolonger receive the Membership fee reduction"));

					$this->debug('Set customer with ID ' . $customerId . ' to non membership group and removed expiration time');
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
