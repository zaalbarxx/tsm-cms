ALTER TABLE  `tsm_reg_families_invoices` ADD  `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER  `due_date`;

UPDATE  `tsm_config` SET  `config_value` =  '.01.015' WHERE  `tsm_config`.`config_id` =1;