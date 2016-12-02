<?php

class TM_EasyFlags_Model_Store extends Mage_Core_Model_Abstract
{

    const CACHE_TAG = 'easyflags_store_';
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('easyflags/store');
    }

}
