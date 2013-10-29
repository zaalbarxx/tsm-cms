ALTER TABLE  `tsm_reg_families_fees` ADD  `removable` TINYINT( 1 ) NOT NULL DEFAULT  '1' AFTER  `family_payment_plan_id`;

ALTER TABLE  `tsm_reg_families_invoices` ADD  `last_updated` TIMESTAMP NOT NULL DEFAULT  '0000-00-00 00:00:00' AFTER  `due_date`;

ALTER TABLE  `tsm_reg_families_invoices` ADD  `last_qb_sync` TIMESTAMP NOT NULL DEFAULT  '0000-00-00 00:00:00' AFTER  `due_date`;

CREATE TABLE `tsm_reg_families_fee_log` (
  `fee_log_id` int(11) NOT NULL AUTO_INCREMENT,
  `family_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `add_remove` tinyint(1) NOT NULL,
  `family_fee_id` int(11) NOT NULL,
  `fee_id` int(11) NOT NULL,
  `fee_name` varchar(255) NOT NULL,
  `program_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `time_logged` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fee_log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;


CREATE TABLE `tsm_reg_families_invoice_fee_log` (
  `fee_log_id` int(11) NOT NULL AUTO_INCREMENT,
  `add_remove` tinyint(1) NOT NULL,
  `family_invoice_id` int(11) NOT NULL,
  `family_fee_id` int(11) NOT NULL,
  `time_logged` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fee_log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

CREATE TABLE `tsm_reg_student_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `program_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `add_remove` tinyint(1) NOT NULL,
  `time_logged` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;


UPDATE  `tsm_config` SET  `config_value` =  '.01.011' WHERE  `tsm_config`.`config_id` =1;