<?php
//core_resource table
$installer = $this;

$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS `{$this->getTable('ymm')}`;
CREATE TABLE `{$this->getTable('ymm')}` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`products_id` INT NOT NULL ,
`products_car_make` VARCHAR( 100 ) NOT NULL ,
`products_car_model` VARCHAR( 100 ) NOT NULL ,
`products_car_year_bof` INT NOT NULL ,
`products_car_year_eof` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 