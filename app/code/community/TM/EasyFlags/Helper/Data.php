<?php

class TM_EasyFlags_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * get easyflags image for store
     * @return mixed string| bool (FALSE if store not found)
     */
    public function getImage($store)
    {

        if (is_object($store)) {
            $storeId = $store->getId();
        } else {
            $storeId = (int)$store;
        }

        if (!$storeId) {
            return false;
        }

        return Mage::getModel('easyflags/store')
            ->load($storeId)
            ->getImage();
    }

    /**
     * get image url
     * @return string
     */
    public function getImageUrl($store)
    {
        $image = $this->getImage($store);
        if (!$image) {
            return '';
        }
        return Mage::getBaseUrl('media')
            . 'easyflags/'
            . $image;
    }

}
