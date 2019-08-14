<?php

class Pektsekye_Ymm_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function getProductIds()
    {
		$where = '';
		
		if (isset($_GET['Make'])){
			if ($_GET['Make'] != 'all')
				$Make_selected_var = $_GET['Make'];
		} elseif (isset($_COOKIE['Make_selected']) && $_COOKIE['Make_selected'] != 'all')	
			$Make_selected_var = $_COOKIE['Make_selected'];
			
		if (isset($_GET['Model'])){
			if ($_GET['Model'] != 'all')
				$Model_selected_var = $_GET['Model'];
		} elseif (isset($_COOKIE['Model_selected']) && $_COOKIE['Model_selected'] != 'all')
			$Model_selected_var = $_COOKIE['Model_selected'];
			
		if (isset($_GET['Year'])){
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
			$rows = $read->fetchAll("SELECT entity_id FROM $productTable LEFT JOIN $ymmTable USING (entity_id) WHERE $where");//ymm_id IS NULL OR 
			
			if(count($rows)>0){
				foreach ($rows as $r)
					$ids [] = $r['entity_id'];
					
					return $ids;
				
			} else 	return false;
	
		} 
			
		return false;
		
    }

}