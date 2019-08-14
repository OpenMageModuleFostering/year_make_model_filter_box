<?php

class Pektsekye_Ymm_Block_Adminhtml_Ymm_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('ymm_form', array('legend'=>Mage::helper('ymm')->__('Item information')));
     
      $fieldset->addField('entity_id', 'text', array(
          'label'     => Mage::helper('ymm')->__('Products ID'),
          'required'  => true,
          'name'      => 'entity_id',
      ));
     
      $fieldset->addField('make', 'text', array(
          'label'     => Mage::helper('ymm')->__('Vehicle Make'),
          'required'  => true,
          'name'      => 'make',
      ));
     
      $fieldset->addField('model', 'text', array(
          'label'     => Mage::helper('ymm')->__('Vehicle Model'),
          'required'  => false,
          'name'      => 'model',
      ));
     
      $fieldset->addField('year_bof', 'text', array(
          'label'     => Mage::helper('ymm')->__('From Year (dddd)'),
          'required'  => false,
          'name'      => 'year_bof',
      ));
     
      $fieldset->addField('year_eof', 'text', array(
          'label'     => Mage::helper('ymm')->__('To Year (dddd)'),
          'required'  => false,
          'name'      => 'year_eof',
      ));	  

      if ( Mage::getSingleton('adminhtml/session')->getYmmData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getYmmData());
          Mage::getSingleton('adminhtml/session')->setYmmData(null);
      } elseif ( Mage::registry('ymm_data') ) {
          $form->setValues(Mage::registry('ymm_data')->getData());
      }
      return parent::_prepareForm();
  }
}