<?php

class Pektsekye_Ymm_Model_Mysql4_Ymm extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the ymm_id refers to the key field in your database table.
        $this->_init('ymm/ymm', 'ymm_id');
    }
}