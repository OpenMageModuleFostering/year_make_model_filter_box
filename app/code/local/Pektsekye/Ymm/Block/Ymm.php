<?php
class Pektsekye_Ymm_Block_Ymm extends Mage_Core_Block_Template
{
		
	public function _prepareLayout()
    {
		if(Mage::getStoreConfig('catalog/navigation/filtering', Mage::app()->getStore()->getStoreId())){
			    Mage::app()->cleanCache(array(Mage_Catalog_Model_Category::CACHE_TAG));
		}

		return parent::_prepareLayout();
    }
    
     public function getYmm()     
     { 
        if (!$this->hasData('ymm')) {
            $this->setData('ymm', Mage::registry('ymm'));
        }
        return $this->getData('ymm');
        
    }
	
}