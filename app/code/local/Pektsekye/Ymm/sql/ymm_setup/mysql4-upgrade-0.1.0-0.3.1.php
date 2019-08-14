<?php
//core_resource table
$installer = $this;

$installer->startSetup();

$installer->run("
 ALTER TABLE `ymm` CHANGE `id` `ymm_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
CHANGE `products_id` `entity_id` INT( 11 ) NOT NULL ,
CHANGE `products_car_make` `make` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
CHANGE `products_car_model` `model` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
CHANGE `products_car_year_bof` `year_bof` INT( 11 ) NOT NULL ,
CHANGE `products_car_year_eof` `year_eof` INT( 11 ) NOT NULL ;
    ");

$installer->endSetup(); 