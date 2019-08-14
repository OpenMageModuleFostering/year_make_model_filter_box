<?php

class Pektsekye_Ymm_Block_Adminhtml_Ymm_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('ymm_form', array('legend'=>Mage::helper('ymm')->__('Item information')));
     
      $fieldset->addField('products_id', 'text', array(
          'label'     => Mage::helper('ymm')->__('Products ID'),
          'required'  => true,
          'name'      => 'products_id',
      ));
     
      $fieldset->addField('products_car_make', 'text', array(
          'label'     => Mage::helper('ymm')->__('Vehicle Make'),
          'required'  => true,
          'name'      => 'products_car_make',
      ));
     
      $fieldset->addField('products_car_model', 'text', array(
          'label'     => Mage::helper('ymm')->__('Vehicle Model'),
          'required'  => false,
          'name'      => 'products_car_model',
      ));
     
      $fieldset->addField('products_car_year_bof', 'text', array(
          'label'     => Mage::helper('ymm')->__('From Year (dddd)'),
          'required'  => false,
          'name'      => 'products_car_year_bof',
      ));
     
      $fieldset->addField('products_car_year_eof', 'text', array(
          'label'     => Mage::helper('ymm')->__('To Year (dddd)'),
          'required'  => false,
          'name'      => 'products_car_year_eof',
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