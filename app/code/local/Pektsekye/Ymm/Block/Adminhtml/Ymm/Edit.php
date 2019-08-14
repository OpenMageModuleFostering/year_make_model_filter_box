<?php

class Pektsekye_Ymm_Block_Adminhtml_Ymm_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'ymm';
        $this->_controller = 'adminhtml_ymm';
        
        $this->_updateButton('save', 'label', Mage::helper('ymm')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('ymm')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('ymm_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'ymm_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'ymm_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('ymm_data') && Mage::registry('ymm_data')->getId() ) {
            return Mage::helper('ymm')->__('Edit Item');
        } else {
            return Mage::helper('ymm')->__('Add Item');
        }
    }
}