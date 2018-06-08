<?php

class TM_EasyFlags_Model_Observer
{

    protected $_fieldNameInForm = 'easyflags_image';

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

        // check if we can render easyflag image
        if ($this->_helper()->getModelName($object)) {
            $newCell = $block->getLayout()
                ->createBlock('adminhtml/template')
                ->setTemplate('tm/easyflags/grid/cell.phtml')
                ->setLinkUrl($block->getLinkUrl())
                ->setStoreObject($object)
                ->setOriginalHtml($transport->getHtml());
            // set new Html
            $transport->setHtml($newCell->toHtml());
        }

    }

    /**
     * listen event adminhtml_store_edit_form_prepare_form to add easyflags set
     * @param Varien_Event_Observer $observer
     */
    public function addFlagFliedToEditForm($observer)
    {

        // find out what form is rendering now
        $storeType = Mage::registry('store_type');
        switch ($storeType) {

            case 'group':
            case 'store':
                // depending on $storeType, registry('store_data') can containe
                // either Mage_Core_Model_Store, or Mage_Core_Model_Store_Group
                $storeObject = Mage::registry('store_data');
                $block = $observer->getData('block');
                $form = $block->getForm();
                // set form Encryption Type that allows to upload files
                $form->setEnctype('multipart/form-data');
                // add easyflags fieldset to form for store view and store group
                $fieldset = $form->addFieldset('easyflags_fieldset', array(
                    'legend' => $this->_helper()->__('Easy Flags')
                ));
                $fieldset->addField(
                    $this->_fieldNameInForm,
                    'image',
                    array(
                        'name'  => $this->_fieldNameInForm,
                        'label' => $this->_helper()->__('Image'),
                        'title' => $this->_helper()->__('Image'),
                        'value' => $this->_helper()->getImageUrl($storeObject)
                    )
                );

                break;

        }

    }

    /**
     * listen events store_edit, store_add, store_group_save to save flags data
     * @param Varien_Event_Observer $observer
     */
    public function saveFlagsData($observer)
    {
        // save flags data for storeview | store group
        //
        if ($observer->hasData('store')){
            $storeObject = $observer->getData('store');
        } elseif ($observer->hasData('group')) {
            $storeObject = $observer->getData('group');
        } else {
            return;
        }

        $modelName = $this->_helper()->getModelName($storeObject);
        if (!$modelName) {
            return;
        }

        $easyflagsModel = Mage::getModel($modelName)
            ->load($storeObject->getId())
            ->setId($storeObject->getId());
        $image = $this->getRequest()->getPost($this->_fieldNameInForm);
        if (is_array($image)) {
            $image['value'] = $easyflagsModel->getImage();
        }

        $storeObject->setEasyflagsImage($image);
        $this->_uploadImage($storeObject);
        $easyflagsModel->setImage($storeObject->getEasyflagsImage());
        $this->_saveFlags($easyflagsModel);

    }

    public function getRequest()
    {
        return Mage::app()->getRequest();
    }

    protected function _uploadImage($object)
    {
        if ($uploader = @Mage::getModel('tmcore/image_uploader')) {
            $mediaDir = Mage::getStoreConfig('easy_flags/general/media_dir');
            $uploader->setDirectory($mediaDir)
                ->upload($object, $this->_fieldNameInForm);
        } else {
            $this->_getSession()
                ->addWarning(
                    $this->_helper()
                        ->__("We can't upload image. Seems like you need to update TM Core module.")
                );
        }

        return $this;
    }

    protected function _saveFlags($object)
    {
        try {
            $object->save();
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            $this->_getSession()->addException($e,
                    $this->_helper()
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

    /**
     * Retrive easyflags helper object
     */
    protected function _helper()
    {
        return Mage::helper('easyflags');
    }

}
