<?php
class Pektsekye_Ymm_Block_Ymm extends Mage_Core_Block_Template
{
	
	protected $_resultPage = null;
		
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
	
	public function setResultPage($resultPage)
    {
            $this->_resultPage = $resultPage;

        return $this;
    }
	
}