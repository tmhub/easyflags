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
                // print_r($object->getInfo());
                $transport->setHtml($transport->getHtml().' FLAG ICON');
                break;
        }

    }

    public function addFlagFliedToEditForm($observer)
    {

        $block = $observer->getData('block');
        $form = $block->getForm();
        $form->addField('test_name_123', 'text', array(
                'name'      => 'test_name_123',
                'label'     => Mage::helper('core')->__('FLAG ICON'),
                'value'     => '$websiteModel->getName()',
            ));

    }

}