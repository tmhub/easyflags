<?php

class TM_Core_Block_Adminhtml_System_Config_Form_Fieldset_Troubleshooting
    extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $html = $this->_getHeaderHtml($element);
        $html .= Mage::helper('tmcore')->__(Mage::getStoreConfig('tmcore/troubleshooting/text'));
        $html .= $this->_getFooterHtml($element);
        return $html;
    }
}
