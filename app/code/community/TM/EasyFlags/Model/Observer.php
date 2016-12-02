<?php

class TM_EasyFlags_Model_Observer
{
    /**
     * listen event adminhtml_block_html_before to add flag pic to grid
     * @param mixed $observer [description]
     */
    public function addFlagToManageStoresGrid($observer)
    {

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
                    ->setStoreObject($object)
                    ->setOriginalHtml($transport->getHtml());
                // set new Html
                $transport->setHtml($newCell->toHtml());
                break;
        }

    }

    public function addFlagFliedToEditForm($observer)
    {

        // find out what form rendered
        $storeType = Mage::registry('store_type');
        switch ($storeType) {

            case 'group':
            case 'store':
                $storeModel = Mage::registry('store_data');
                $block = $observer->getData('block');
                // Zend_Debug::dump($observer->getData()); die;
                $form = $block->getForm();
                // add easyflags fieldset to form for store view and store group
                $fieldset = $form->addFieldset('easyflags_fieldset', array(
                    'legend' => Mage::helper('easyflags')->__('Easy Flags')
                ));
                $fieldset->addField(
                    $storeType . '_easyflags_image',
                    'image',
                    array(
                        'name'  => $storeType . '[easyflags_image]',
                        'label' => Mage::helper('easyflags')->__('Image'),
                        'title' => Mage::helper('easyflags')->__('Image'),
                        'value' => Mage::helper('easyflags')->getImageUrl($storeModel)
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
            Zend_Debug::dump($storeModel->getData());
            die();
        }
    }
}
