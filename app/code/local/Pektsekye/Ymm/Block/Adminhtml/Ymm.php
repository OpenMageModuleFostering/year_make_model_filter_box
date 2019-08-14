<?php
class Pektsekye_Ymm_Block_Adminhtml_Ymm extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_ymm';
    $this->_blockGroup = 'ymm';
    $this->_headerText = Mage::helper('ymm')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('ymm')->__('Add Item');
    parent::__construct();
  }
}