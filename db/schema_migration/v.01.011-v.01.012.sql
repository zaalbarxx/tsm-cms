ALTER TABLE  `tsm_reg_families_fees` ADD  `to_review` TINYINT( 1 ) NOT NULL DEFAULT  '0' AFTER  `removable`;

UPDATE  `tsm_config` SET  `config_value` =  '.01.012' WHERE  `tsm_config`.`config_id` =1;