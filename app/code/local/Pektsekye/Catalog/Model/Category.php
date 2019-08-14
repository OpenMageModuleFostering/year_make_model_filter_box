<?php

class Pektsekye_Catalog_Model_Category extends Mage_Catalog_Model_Category
{
	
/**  Override core magento function 
     * Get category products collection
     *
     * @return Varien_Data_Collection_Db
     */
    public function getProductCollection()
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

			$collection = Mage::getResourceModel('catalog/product_collection')
				->setStoreId($this->getStoreId())
				->addCategoryFilter($this)
				->addIdFilter($ids);
			
		} else {
			
			$collection = Mage::getResourceModel('catalog/product_collection')
				->setStoreId($this->getStoreId())
				->addCategoryFilter($this);
		}

        return $collection;
    }
	
}