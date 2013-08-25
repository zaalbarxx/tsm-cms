ALTER TABLE `tsm_reg_families` ADD `active` BOOLEAN NOT NULL DEFAULT TRUE;

ALTER TABLE `tsm_reg_students` ADD `active` BOOLEAN NOT NULL DEFAULT TRUE;

UPDATE  `tsm_config` SET  `config_value` =  '.01.017' WHERE  `tsm_config`.`config_id` =1;