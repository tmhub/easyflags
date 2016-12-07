<?php

class TM_EasyFlags_Model_Resource_Store_Group
    extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Standard resource model initialization
     * Set main table
     */
    protected function _construct()
    {
        // allow insert record with specified key field
        $this->_isPkAutoIncrement = false;
        $this->_init('easyflags/storegroup', 'group_id');
    }
}
