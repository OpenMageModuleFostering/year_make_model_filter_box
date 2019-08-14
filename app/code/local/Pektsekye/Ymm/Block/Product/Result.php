<?php


class Pektsekye_Ymm_Block_Product_Result extends Mage_Catalog_Block_Product_Abstract
{
    protected $_productCollection;

    protected function _prepareLayout()
    {
        $title = $this->getHeaderText();
        $this->getLayout()->getBlock('head')->setTitle($title);
        $this->getLayout()->getBlock('root')->setHeaderTitle($title);
        return parent::_prepareLayout();
    }

    public function setListOrders() {
        $this->getChild('search_result_list')
            ->setAvailableOrders(array(
                'name' => Mage::helper('ymm')->__('Name'),
                'price'=>Mage::helper('ymm')->__('Price'))
            );
    }

    public function setListModes() {
        $this->getChild('search_result_list')
            ->setModes(array(
                'grid' => Mage::helper('ymm')->__('Grid'),
                'list' => Mage::helper('ymm')->__('List'))
            );
    }

    public function setListCollection() {
        $this->getChild('search_result_list')
           ->setCollection($this->_getProductCollection());
    }

    public function getProductListHtml()
    {
        return $this->getChildHtml('search_result_list');
    }

    protected function _getProductCollection()
    {

        if (is_null($this->_productCollection)) {
            $this->_productCollection = Mage::getSingleton('catalogsearch/layer')->getProductCollection();
        }
		
        return $this->_productCollection;
    }

    public function getResultCount()
    {
        if (!$this->getData('result_count')) {
            $size = $this->_getProductCollection()->getSize();
            $this->setResultCount($size);
        }
        return $this->getData('result_count');
    }

    public function getHeaderText()
    {
		
		$make = $this->getRequest()->getParam('Make');
		$model = $this->getRequest()->getParam('Model');
		$year = $this->getRequest()->getParam('Year');
		
        if($make && $make != 'all') {			
			$make = $this->getRequest()->getParam('Make');
			
			if($model == 'all')
				$model = '';
			
			if($year == 0)		
				$year = '';
				
			return Mage::helper('ymm')->__("Products for %s", $this->htmlEscape("$make $model $year"));
				
        } else {
            return false;
        }
    }

    public function getSubheaderText()
    {
        return false;
    }

    public function getNoResultText()
    {
        return Mage::helper('ymm')->__('No matches found.');
    }
}
