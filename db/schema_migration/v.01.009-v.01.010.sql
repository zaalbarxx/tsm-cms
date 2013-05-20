ALTER TABLE  `tsm_reg_families_invoice_email` ADD  `email_subject` VARCHAR( 255 ) NOT NULL AFTER  `family_id`;

ALTER TABLE  `tsm_reg_families_invoice_email` ADD  `email_contents` LONGTEXT NOT NULL AFTER  `email_subject`;

ALTER TABLE  `tsm_reg_families_invoice_email` ADD  `sent_to` VARCHAR( 255 ) NOT NULL AFTER  `email_contents`;

UPDATE  `tsm_config` SET  `config_value` =  '.01.010' WHERE  `tsm_config`.`config_id` =1;