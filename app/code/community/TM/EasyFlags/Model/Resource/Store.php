<?php

class TM_EasyFlags_Model_Resource_Store
    extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        // allow insert record with specified key field
        $this->_isPkAutoIncrement = false;
        $this->_init('easyflags/store', 'store_id');
    }
}
