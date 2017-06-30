<?php

namespace PlymDesign\GroupChange\Setup;

use Psr\Log\LoggerInterface;

use Magento\Framework\Setup\InstallSchemaInterface;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{

	/**
	 * Determine whether to write to debug log
	 *
	 * @var bool
	 */
	private $use_debug = true;

	/**
	 * Logger Interface for writing to log files in \var\log\
	 *
	 * @var LoggerInterface
	 */
	protected $logger;

	/**
	 * Constructor for setting interfaces
	 *
	 * @param LoggerInterface $loggerInterface Logger Interface to be referenced and used
	 *
	 * @return void
	 */
	public function __construct(LoggerInterface $loggerInterface)
	{
		$this->logger = $loggerInterface;
	}

	/**
	 * Method called during initial installation of the module
	 *
	 * Creates a new column in the Customer table for date of purchase of a membership item
	 *
	 * @param SchemaSetupInterface $setup
	 * @param ModuleContextInterface $context
	 *
	 * @return void
	 */
	public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
		//Write to Debug Log
        $this->logger->debug('InstallSchema for GroupChange executing...');

		//Prepare database for updates to tables and columns
		$setup->startSetup();

		//Add a new column, 'membership_expiration_date', to table 'customer_entity'
		$setup->getConnection()->addColumn(
			$setup->getTable('customer_entity'),
			'membership_expiration_date',
			['type' => \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
			'nullable' => true,
			'default' => null,
            'comment' => 'Membership Expiration Date']
		);

		//Finalize setup of the database
		$setup->endSetup();
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