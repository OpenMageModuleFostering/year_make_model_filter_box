<?php
//core_resource table
$installer = $this;

$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('ymm')};
CREATE TABLE {$this->getTable('ymm')} (
`ymm_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`entity_id` INT NOT NULL ,
`make` VARCHAR( 100 ) NOT NULL ,
`model` VARCHAR( 100 ) NOT NULL ,
`year_bof` INT NOT NULL ,
`year_eof` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 