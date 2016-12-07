<?php

class TM_EasyFlags_Model_Store_Group extends Mage_Core_Model_Abstract
{

    const CACHE_TAG = 'easyflags_store_group_';
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('easyflags/store_group');
    }

}
