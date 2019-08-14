<?php
class Pektsekye_Ymm_Block_Ymm extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
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