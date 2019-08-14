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
		$expire = time()+60*60*24*90;
		$where = "";
		
		if (isset($_GET['Make'])){
			setcookie("Make_selected", $_GET['Make'], $expire,'/');
			if ($_GET['Make'] != 'all')
				$Make_selected_var = $_GET['Make'];
		} elseif (isset($_COOKIE['Make_selected']) && $_COOKIE['Make_selected'] != 'all')	
			$Make_selected_var = $_COOKIE['Make_selected'];
			
		if (isset($_GET['Model'])){
			setcookie("Model_selected", $_GET['Model'], $expire,'/'); 
			if ($_GET['Model'] != 'all')
				$Model_selected_var = $_GET['Model'];
		} elseif (isset($_COOKIE['Model_selected']) && $_COOKIE['Model_selected'] != 'all')
			$Model_selected_var = $_COOKIE['Model_selected'];
			
		if (isset($_GET['Year'])){
			setcookie("Year_selected", $_GET['Year'], $expire,'/');
			if ($_GET['Year'] != 0)
				$Year_selected_var = $_GET['Year'];
		} elseif (isset($_COOKIE['Year_selected']) && $_COOKIE['Year_selected'] != 0)
			$Year_selected_var = $_COOKIE['Year_selected'];
			

		if (isset($Make_selected_var))
			$where .= " (make='".$Make_selected_var."' or make='') ";

		if (isset($Model_selected_var))
			$where .= ($where != '' ? ' and ' : '') . " (model='".$Model_selected_var."' or model='') ";

		if (isset($Year_selected_var))
			$where .= ($where != '' ? ' and ' : '') . " ((year_bof <= '".$Year_selected_var."' and year_eof >= '".$Year_selected_var."') or (year_bof=0  and year_eof=0)) ";	


		if ($where != ''){

			$resource = Mage::getSingleton('core/resource'); 
			$read= $resource->getConnection('core_read');
			$productTable = $resource->getTableName('catalog_product_entity');
			$ymmTable = $resource->getTableName('ymm');
			$rows = $read->fetchAll("SELECT entity_id FROM $productTable LEFT JOIN $ymmTable USING (entity_id) WHERE ymm_id IS NULL OR $where");

			foreach ($rows as $r)
				$ids [] = $r['entity_id'];
					
            $this->_productCollection = Mage::getResourceModel('catalog/product_collection')
				->setStoreId($this->getStoreId())
                ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                ->addIdFilter($ids)
                ->addStoreFilter()
                ->addMinimalPrice()
                ->addUrlRewrite();
            Mage::getSingleton('catalog/product_status')->addSaleableFilterToCollection($this->_productCollection);
            Mage::getSingleton('catalog/product_visibility')->addVisibleInSiteFilterToCollection($this->_productCollection);
        } else {
			
            $this->_productCollection = Mage::getResourceModel('catalog/product_collection')
				->setStoreId($this->getStoreId())
                ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                ->addStoreFilter()
                ->addMinimalPrice()
                ->addUrlRewrite();		
            Mage::getSingleton('catalog/product_status')->addSaleableFilterToCollection($this->_productCollection);
            Mage::getSingleton('catalog/product_visibility')->addVisibleInSiteFilterToCollection($this->_productCollection);			
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
