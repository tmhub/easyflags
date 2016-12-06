<?php

class TM_EasyFlags_Model_Observer
{
    /**
     * listen event adminhtml_block_html_before to add flag pic to grid
     * @param mixed $observer [description]
     */
    public function addFlagToManageStoresGrid($observer)
    {

        // works only on pages */system_store/index/*
        if ($this->getRequest()->getControllerName() != 'system_store' ||
            $this->getRequest()->getActionName() != 'index') {
            return;
        }

        // get block
        if (!$observer->hasData('block')) {
            return;
        }
        $block = $observer->getData('block');

        // get object from block
        if (!$block->hasData('object')) {
            return;
        }
        $object = $block->getData('object');
        $transport = $observer->getData('transport');

        // check class object
        switch (get_class($object)) {
            // store view
            case 'Mage_Core_Model_Store':
                $newCell = $block->getLayout()
                    ->createBlock('adminhtml/template')
                    ->setTemplate('tm/easyflags/grid/cell.phtml')
                    ->setLinkUrl($block->getLinkUrl())
                    ->setStoreObject($object)
                    ->setOriginalHtml($transport->getHtml());
                // set new Html
                $transport->setHtml($newCell->toHtml());
                break;
        }

    }

    public function addFlagFliedToEditForm($observer)
    {

        // find out what form is rendering now
        $storeType = Mage::registry('store_type');
        switch ($storeType) {

            case 'group':
            case 'store':
                $storeModel = Mage::registry('store_data');
                $block = $observer->getData('block');
                $form = $block->getForm();
                // set form Encryption Type that allows to upload files
                $form->setEnctype('multipart/form-data');
                // add easyflags fieldset to form for store view and store group
                $fieldset = $form->addFieldset('easyflags_fieldset', array(
                    'legend' => Mage::helper('easyflags')->__('Easy Flags')
                ));
                $fieldset->addField(
                    $storeType . '_easyflags_image',
                    'image',
                    array(
                        'name'  => $storeType . '_easyflags_image',
                        'label' => Mage::helper('easyflags')->__('Image'),
                        'title' => Mage::helper('easyflags')->__('Image'),
                        'value' => Mage::helper('easyflags')
                                    ->getImageUrl($storeModel)
                    )
                );

                break;

        }

    }

    public function saveFlagsData($observer)
    {
        if ($observer->hasData('store')) {
            // save flags data fro storeview
            $storeModel = $observer->getData('store');
            $storeModel->setEasyflagsImage(
                    $this->getRequest()->getPost('store_easyflags_image')
                );
            $this->_uploadImage($storeModel);
            $easyflagsModel = Mage::getModel('easyflags/store')
                ->setId($storeModel->getId())
                ->setImage($storeModel->getEasyflagsImage());
            $this->_saveFlags($easyflagsModel);
        }
    }

    public function getRequest()
    {
        return Mage::app()->getRequest();
    }

    protected function _uploadImage($object)
    {
        $newImage = isset($_FILES['store_easyflags_image']) ?
            $_FILES['store_easyflags_image'] : false;

        $oldImage = $object->getEasyflagsImage();


        // check if we should delete old image
        if (is_array($oldImage) && !empty($oldImage['delete'])) {
            $oldImagePath = Mage::helper('easyflags')->getImagePath($object);
            @unlink($oldImagePath);
            $object ->setEasyflagsImage('');
        }

        if (isset($newImage['name']) && $newImage['name']) {
            try {
                $uploader = new Varien_File_Uploader('store_easyflags_image');
                $uploader->setAllowedExtensions(
                        array('jpg','jpeg','gif','png', 'bmp')
                    );
                $uploader->setAllowRenameFiles(true);
                $uploader->save(Mage::helper('easyflags')->getBaseDir());
                $object->setEasyflagsImage($uploader->getUploadedFileName());
            } catch (Exception $e) {
                $object->setEasyflagsImage('');
                throw $e;
            }
        }
    }

    protected function _saveFlags($object)
    {
        try {
            $object->save();
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            $this->_getSession()->addException($e,
                    Mage::helper('easyflags')
                        ->__('An error occurred while saving EasyFlags data.')
                );
        }
    }

    /**
     * Retrieve adminhtml session model object
     *
     * @return Mage_Adminhtml_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('adminhtml/session');
    }

}
