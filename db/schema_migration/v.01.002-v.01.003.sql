ALTER TABLE  `tsm_reg_families_payment_invoice` CHANGE  `last_updated`  `time_payment_applied` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

UPDATE tsm_reg_families_payment_invoice pi, tsm_reg_families_payments fp SET time_payment_applied = payment_time WHERE pi.family_payment_id = fp.family_payment_id;

UPDATE  `tsm_config` SET  `config_value` =  '.01.003' WHERE  `tsm_config`.`config_id` =1;