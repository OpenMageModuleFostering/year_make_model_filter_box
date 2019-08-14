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
		
		$helper = new Pektsekye_Ymm_Helper_Data;

		if($ids = $helper->getProductIds()){ 

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