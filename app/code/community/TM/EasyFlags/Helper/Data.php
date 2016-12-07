<?php

class TM_EasyFlags_Helper_Data extends Mage_Core_Helper_Abstract
{

    protected $_modelNameMapping = array(
        'Mage_Core_Model_Store' => 'easyflags/store',
        'Mage_Core_Model_Store_Group' => 'easyflags/store_group'
    );

    /**
     * get easyflags image for store or store group
     *
     * @param  mixed $object Mage_Core_Model_Store|..._Store_Group
     * @return mixed string|bool (FALSE if store not found)
     */
    public function getImage($object)
    {
        $modelName = $this->getModelName($object);
        if (!$modelName) {
            return false;
        }
        return Mage::getModel($modelName)
            ->load($object->getId())
            ->getImage();
    }

    /**
     * get easyflags image url for store or store group
     *
     * @param  mixed $object Mage_Core_Model_Store|..._Store_Group
     * @return string
     */
    public function getImageUrl($object)
    {
        $image = $this->getImage($object);
        if (!$image) {
            return '';
        }
        return rtrim(Mage::getBaseUrl('media'), '/')
            . '/'
            . trim(Mage::getStoreConfig('easy_flags/general/media_dir'), DS)
            . '/'
            . $image;
    }

    /**
     * get easyflags image path for store or store group
     *
     * @param  mixed $object Mage_Core_Model_Store|..._Store_Group
     * @return string
     */
    public function getImagePath($object)
    {
        $image = $this->getImage($object);
        if (!$image) {
            return '';
        }
        return $this->getBaseDir()
            . $image;
    }

    public function getBaseDir()
    {
        return rtrim(Mage::getBaseDir('media'), DS)
            . DS
            . trim(Mage::getStoreConfig('easy_flags/general/media_dir'), DS)
            . DS;
    }

    /**
     * get easyflags model name for object
     *
     * @param  mixed $object Mage_Core_Model_Store|..._Store_Group
     * @return string
     */
    public function getModelName($object)
    {
        if (!isset($this->_modelNameMapping[get_class($object)])) {
            return false;
        }
        return $this->_modelNameMapping[get_class($object)];
    }

}
