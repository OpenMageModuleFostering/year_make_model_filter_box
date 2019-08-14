<?php

class Pektsekye_Ymm_Model_Ymm extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('ymm/ymm');
    }
}