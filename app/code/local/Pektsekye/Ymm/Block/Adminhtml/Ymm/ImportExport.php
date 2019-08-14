<?php

class Pektsekye_Ymm_Block_Adminhtml_Ymm_importExport extends Mage_Adminhtml_Block_Widget
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('ymm/importExport.phtml');
    }
}