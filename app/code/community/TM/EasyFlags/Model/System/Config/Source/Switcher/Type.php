<?php

class TM_EasyFlags_Model_System_Config_Source_Switcher_Type
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 'dropdown',
                'label' => Mage::helper('easyflags')->__('Chosen Dropdown')
            ),
            array(
                'value' => 'inline',
                'label' => Mage::helper('easyflags')->__('Inline')
            ),
            array(
                'value' => '0',
                'label' => Mage::helper('easyflags')->__('Default')
            )
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'dropdown' =>
                age::helper('easyflags')->__('Dropdown'),
            'inline' =>
                Mage::helper('easyflags')->__('Inline'),
            '0' =>
                Mage::helper('easyflags')->__('Default')
        );
    }

}