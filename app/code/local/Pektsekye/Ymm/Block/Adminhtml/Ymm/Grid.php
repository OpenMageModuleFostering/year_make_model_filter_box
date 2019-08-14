<?php

class Pektsekye_Ymm_Block_Adminhtml_Ymm_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
	 // $this->setEmptyText(Mage::helper('ymm')->__('This product is set to be always shown'));
      $this->setId('ymmGrid');
      $this->setDefaultSort('id');
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
      $this->addColumn('id', array(
          'header'    => Mage::helper('ymm')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('products_id', array(
          'header'    => Mage::helper('ymm')->__('Products ID'),
          'align'     =>'left',
          'index'     => 'products_id',
      ));
	  
      $this->addColumn('products_car_make', array(
          'header'    => Mage::helper('ymm')->__('Vehicle Make'),
          'align'     =>'left',
          'index'     => 'products_car_make',
      ));

      $this->addColumn('products_car_model', array(
          'header'    => Mage::helper('ymm')->__('Vehicle Model'),
          'align'     =>'left',
          'index'     => 'products_car_model',
      ));

      $this->addColumn('products_car_year_bof', array(
          'header'    => Mage::helper('ymm')->__('From Year'),
          'align'     =>'left',
          'index'     => 'products_car_year_bof',
      ));

      $this->addColumn('products_car_year_eof', array(
          'header'    => Mage::helper('ymm')->__('To Year'),
          'align'     =>'left',
          'index'     => 'products_car_year_eof',
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
		
		$this->addExportType('*/*/exportCsv', Mage::helper('ymm')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('ymm')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('ymm');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('ymm')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('ymm')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('ymm/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('ymm')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('ymm')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}