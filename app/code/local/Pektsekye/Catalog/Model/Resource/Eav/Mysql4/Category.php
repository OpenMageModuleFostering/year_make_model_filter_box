<?php

class Pektsekye_Catalog_Model_Resource_Eav_Mysql4_Category extends Mage_Catalog_Model_Resource_Eav_Mysql4_Category
{


    /**Override core magento class
     * Retrieve categories
     *
     * @param integer $parent
     * @param integer $recursionLevel
     * @param boolean|string $sorted
     * @param boolean $asCollection
     * @param boolean $toLoad
     * @return Varien_Data_Tree_Node_Collection|Mage_Catalog_Model_Resource_Eav_Mysql4_Category_Collection
     */
    public function getCategories($parent, $recursionLevel = 0, $sorted=false, $asCollection=false, $toLoad=true)
    {
        $tree = Mage::getResourceModel('catalog/category_tree');
        /** @var $tree Mage_Catalog_Model_Resource_Eav_Mysql4_Category_Tree */
		
		if(Mage::getStoreConfig('catalog/navigation/filtering', Mage::app()->getStore()->getStoreId())){	
		
			$helper = new Pektsekye_Ymm_Helper_Data;

			if($ids = $helper->getProductIds()){
				
				$pids = implode(',',$ids);
				$resource = Mage::getSingleton('core/resource'); 
				$read= $resource->getConnection('core_read');
				$categoryTable = $resource->getTableName('catalog_category_entity');
				$category_productTable = $resource->getTableName('catalog/category_product_index');			
				$rows = $read->fetchAll("SELECT entity_id FROM $categoryTable WHERE entity_id NOT IN (SELECT DISTINCT category_id FROM $category_productTable WHERE product_id in ($pids)) ");
				
				if(count($rows)>0)
				foreach ($rows as $r)
					$ids [] = $r['entity_id'];
					
				$tree->addInactiveCategoryIds($ids);
				
			}
		
		}
		
        $nodes = $tree->loadNode($parent)
            ->loadChildren($recursionLevel)
            ->getChildren();

        $tree->addCollectionData(null, $sorted, $parent, $toLoad, true);

        if ($asCollection) {
            return $tree->getCollection();
        }
        return $nodes;
    }

  
}