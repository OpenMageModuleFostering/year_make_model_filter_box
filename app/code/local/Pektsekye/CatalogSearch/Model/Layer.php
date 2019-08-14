<?php


class Pektsekye_CatalogSearch_Model_Layer extends Mage_CatalogSearch_Model_Layer
{

    /**Override core magento method
     * Get current layer product collection
     *
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection
     */
    public function getProductCollection()
    {
        if (isset($this->_productCollections[$this->getCurrentCategory()->getId()])) {
            $collection = $this->_productCollections[$this->getCurrentCategory()->getId()];
        }
        else {
			
			$helper = new Pektsekye_Ymm_Helper_Data;
			$ids = $helper->getProductIds();

			if($ids){ 

				if(Mage::helper('catalogSearch')->getEscapedQueryText() && Mage::getStoreConfig('catalog/search/filtering', Mage::app()->getStore()->getStoreId())){
					$collection = Mage::getResourceModel('catalogsearch/fulltext_collection')
						->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
						->addSearchFilter(Mage::helper('catalogSearch')->getEscapedQueryText())
						->addIdFilter($ids)						
						->setStore(Mage::app()->getStore())
						->addMinimalPrice()
						->addFinalPrice()
						->addTaxPercents()
						->addStoreFilter()
						->addUrlRewrite();
						
				} elseif (!Mage::helper('catalogSearch')->getEscapedQueryText()){
					
					$collection = Mage::getResourceModel('catalog/product_collection')
								->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
								->addIdFilter($ids)
								->setStore(Mage::app()->getStore())
								->addMinimalPrice()
								->addFinalPrice()
								->addTaxPercents()
								->addStoreFilter()
								->addUrlRewrite();	
								
				} else {
					
					$collection = Mage::getResourceModel('catalogsearch/fulltext_collection');
					$this->prepareProductCollection($collection);
					
				}
				
				Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
				Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($collection);
			
			} else {
				
				$collection = Mage::getResourceModel('catalogsearch/fulltext_collection');
				$this->prepareProductCollection($collection);
			}

            $this->_productCollections[$this->getCurrentCategory()->getId()] = $collection;
        }

        return $collection;
    }

}