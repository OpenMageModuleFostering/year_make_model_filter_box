<?php

class Pektsekye_Ymm_ProductController extends Mage_Core_Controller_Front_Action
{

    public function listAction()
    { 
        if(!$this->getRequest()->getParam('Make') || $this->getRequest()->getParam('Make') == 'all') {
			 $this->getResponse()->setRedirect(Mage::getBaseUrl());
            return;
        }
		
		if(!Mage::helper('ymm')->getProductIds()){
			$this->getResponse()->setRedirect(Mage::getBaseUrl());
            return;
		}
		
        $this->loadLayout();
        $this->_initLayoutMessages('checkout/session');
        $this->_initLayoutMessages('tag/session');
        $this->renderLayout();
    }
}