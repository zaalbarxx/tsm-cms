ALTER TABLE  `tsm_reg_families_fees` CHANGE  `program_id`  `program_id` INT( 10 ) NULL;

UPDATE  `tsm_config` SET  `config_value` =  '.01.013' WHERE  `tsm_config`.`config_id` =1;