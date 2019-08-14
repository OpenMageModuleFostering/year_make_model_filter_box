<?php

class Pektsekye_Ymm_Block_Adminhtml_Ymm_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('ymm_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('ymm')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('ymm')->__('Item Information'),
          'title'     => Mage::helper('ymm')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('ymm/adminhtml_ymm_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}