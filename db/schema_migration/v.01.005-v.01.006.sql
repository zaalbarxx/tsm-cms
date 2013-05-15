ALTER TABLE  `tsm_reg_families_invoices` ADD  `invoice_and_credit` TINYINT( 1 ) NOT NULL AFTER  `displayed`;

UPDATE tsm_reg_families_invoices SET invoice_and_credit = 1 WHERE displayed = 0;

CREATE TABLE `tsm_reg_families_invoice_email` (
  `invoice_email_id` int(11) NOT NULL AUTO_INCREMENT,
  `family_invoice_id` int(11) NOT NULL,
  `family_id` int(11) NOT NULL,
  `email_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`invoice_email_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE  `tsm_reg_campuses` ADD  `invoice_email_address` VARCHAR( 255 ) NOT NULL AFTER  `pay_by_mail_message`;

ALTER TABLE  `tsm_reg_fee_payment_plans` ADD  `invoice_email` LONGTEXT NOT NULL AFTER  `installment_description`;

ALTER TABLE  `tsm_reg_fee_payment_plans` ADD  `invoice_email_subject` VARCHAR( 255 ) NOT NULL AFTER  `invoice_email`;

UPDATE  `tsm_config` SET  `config_value` =  '.01.006' WHERE  `tsm_config`.`config_id` =1;