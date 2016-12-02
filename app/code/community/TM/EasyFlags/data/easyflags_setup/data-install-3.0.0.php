<?php

$stores = Mage::getModel('core/store')->getCollection();
$configPath = 'easy_flags/general/store_image';

foreach ($stores as $store) {
    $flagsStore = Mage::getModel('easyflags/store')
        ->setStoreId($store->getId())
        ->setImage(Mage::getStoreConfig($configPath, $store->getId()));
    if ($flagsStore->getImage()) {
        $flagsStore->save();
    }
}
