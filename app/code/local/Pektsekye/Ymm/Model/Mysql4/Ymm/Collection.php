<?php

class Pektsekye_Ymm_Model_Mysql4_Ymm_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('ymm/ymm');
    }
}