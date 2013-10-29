ALTER TABLE tsm_reg_families ADD COLUMN password_reset_token VARCHAR(128);
ALTER TABLE tsm_reg_families ADD COLUMN password_reset_expire TIMESTAMP;

UPDATE  `tsm_config` SET  `config_value` =  '.01.021' WHERE  `tsm_config`.`config_id` =1;