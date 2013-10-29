ALTER TABLE tsm_reg_families_invoice_fees ADD COLUMN soft_deleted BOOLEAN DEFAULT FALSE;

UPDATE  `tsm_config` SET  `config_value` =  '.01.015' WHERE  `tsm_config`.`config_id` =1;