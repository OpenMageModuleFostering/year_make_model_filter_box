<?php
/*
Written by pektsekye@gmail.com on Tuesday Jul 21  2009
version 1.0
*/

class Pektsekye_Adminhtml_Block_Page_Footer extends Mage_Adminhtml_Block_Page_Footer
{

/**
 * Override Mage Adminhtml footer block
 */
    public function getLanguageSelect()
    { 
        $html = $this->getLayout()->createBlock('adminhtml/html_select')
            ->setName('locale')
            ->setId('interface_locale')
            ->setTitle(Mage::helper('page')->__('Interface Language'))
            ->setExtraParams('style="width:200px"')
            ->setValue(Mage::app()->getLocale()->getLocaleCode())
            ->setOptions(Mage::app()->getLocale()->getOptionLocales())
            ->getHtml();
        return $html;
    }

}
