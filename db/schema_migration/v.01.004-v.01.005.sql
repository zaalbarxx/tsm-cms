ALTER TABLE  `tsm_reg_fee_payment_plans` ADD  `qb_invoice_class_id` VARCHAR( 255 ) NOT NULL AFTER  `num_invoices`;

ALTER TABLE  `tsm_reg_fee_payment_plans` ADD  `qb_credit_class_id` VARCHAR( 255 ) NOT NULL AFTER  `num_invoices`;

ALTER TABLE  `tsm_reg_campuses` ADD  `paypal_convenience_fee_qb_class_id` VARCHAR( 255 ) NOT NULL AFTER  `paypal_convenience_fee_id`;

UPDATE  `tsm_config` SET  `config_value` =  '.01.005' WHERE  `tsm_config`.`config_id` =1;