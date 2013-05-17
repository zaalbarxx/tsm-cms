ALTER TABLE  `tsm_reg_families_invoices` ADD  `due_date` DATE NOT NULL AFTER  `invoice_and_credit`;

UPDATE tsm_reg_families_invoices SET due_date = invoice_time;

UPDATE tsm_reg_families_invoices SET due_date = '2013-05-01' WHERE invoice_description LIKE '%registration%';

UPDATE  `tsm_config` SET  `config_value` =  '.01.008' WHERE  `tsm_config`.`config_id` =1;