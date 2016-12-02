<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Create table 'easyflags/store'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('easyflags/store'))
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Store Id')
    ->addColumn('image', Varien_Db_Ddl_Table::TYPE_TEXT, 100, array(
        'nullable'  => true
        ), 'Image')
    ->addForeignKey($installer->getFkName('easyflags/store', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Easyflags data for store view');
$installer->getConnection()->createTable($table);

/**
 * Create table 'easyflags/storegroup'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('easyflags/storegroup'))
    ->addColumn('group_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Group Id')
    ->addColumn('image', Varien_Db_Ddl_Table::TYPE_TEXT, 100, array(
        'nullable'  => true
        ), 'Image')
    ->addForeignKey($installer->getFkName('easyflags/storegroup', 'group_id', 'core/store_group', 'group_id'),
        'group_id', $installer->getTable('core/store_group'), 'group_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Easyflags data for store group');
$installer->getConnection()->createTable($table);

$installer->endSetup();
