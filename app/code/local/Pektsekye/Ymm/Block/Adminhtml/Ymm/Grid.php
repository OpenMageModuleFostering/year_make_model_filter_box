<?php

class Pektsekye_Ymm_Block_Adminhtml_Ymm_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('ymmGrid');
      $this->setDefaultSort('ymm_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('ymm/ymm')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {

      $this->addColumn('entity_id', array(
          'header'    => Mage::helper('ymm')->__('Products ID'),
          'align'     =>'left',
          'index'     => 'entity_id',
      ));
	  
      $this->addColumn('make', array(
          'header'    => Mage::helper('ymm')->__('Vehicle Make'),
          'align'     =>'left',
          'index'     => 'make',
      ));

      $this->addColumn('model', array(
          'header'    => Mage::helper('ymm')->__('Vehicle Model'),
          'align'     =>'left',
          'index'     => 'model',
      ));

      $this->addColumn('year_bof', array(
          'header'    => Mage::helper('ymm')->__('From Year'),
          'align'     =>'left',
          'index'     => 'year_bof',
      ));

      $this->addColumn('year_eof', array(
          'header'    => Mage::helper('ymm')->__('To Year'),
          'align'     =>'left',
          'index'     => 'year_eof',
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('ymm')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('ymm')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('ymm_id');
        $this->getMassactionBlock()->setFormFieldName('ymm');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('ymm')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('ymm')->__('Are you sure?')
        ));
		
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}