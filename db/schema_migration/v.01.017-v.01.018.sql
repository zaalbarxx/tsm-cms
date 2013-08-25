ALTER TABLE  `tsm_reg_families_invoices` ADD  `credit_memo` TINYINT( 1 ) NOT NULL DEFAULT  '0' AFTER  `due_date`;

UPDATE tsm_reg_families_invoices SET credit_memo = 1 WHERE invoice_description LIKE '%offset%' OR amount < 0;

UPDATE  `tsm_config` SET  `config_value` =  '.01.017' WHERE  `tsm_config`.`config_id` =1;