ALTER TABLE tsm_reg_families_fees ADD COLUMN credit boolean NOT NULL DEFAULT false;

UPDATE  `tsm_config` SET  `config_value` =  '.01.020' WHERE  `tsm_config`.`config_id` =1;