ALTER TABLE  `tsm_reg_families_invoices` ADD  `invoice_and_credit` TINYINT( 1 ) NOT NULL AFTER  `displayed`;

UPDATE tsm_reg_families_invoices SET invoice_and_credit = 1 WHERE displayed = 0;

UPDATE  `tsm_config` SET  `config_value` =  '.01.006' WHERE  `tsm_config`.`config_id` =1;