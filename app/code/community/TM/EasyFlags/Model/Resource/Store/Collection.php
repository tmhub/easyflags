<?php

class TM_EasyFlags_Model_Resource_Store_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Define resource model
     *
     */
    protected function _construct()
    {
        $this->_init('easyflags/store');
    }

}
