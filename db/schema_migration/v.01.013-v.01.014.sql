ALTER TABLE  `tsm_reg_campuses` ADD  `auto_invoicing_enabled` TINYINT( 1 ) NOT NULL AFTER  `invoice_prefix`;

UPDATE  `tsm_config` SET  `config_value` =  '.01.014' WHERE  `tsm_config`.`config_id` =1;