-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 01, 2013 at 08:11 PM
-- Server version: 5.5.25
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `takesixm_sandbox`
--

-- --------------------------------------------------------

--
-- Table structure for table `quickbooks_config`
--

CREATE TABLE `quickbooks_config` (
  `quickbooks_config_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qb_username` varchar(40) NOT NULL,
  `module` varchar(40) NOT NULL,
  `cfgkey` varchar(40) NOT NULL,
  `cfgval` varchar(40) NOT NULL,
  `cfgtype` varchar(40) NOT NULL,
  `cfgopts` text NOT NULL,
  `write_datetime` datetime NOT NULL,
  `mod_datetime` datetime NOT NULL,
  PRIMARY KEY (`quickbooks_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quickbooks_log`
--

CREATE TABLE `quickbooks_log` (
  `quickbooks_log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quickbooks_ticket_id` int(10) unsigned DEFAULT NULL,
  `batch` int(10) unsigned NOT NULL,
  `msg` text NOT NULL,
  `log_datetime` datetime NOT NULL,
  PRIMARY KEY (`quickbooks_log_id`),
  KEY `quickbooks_ticket_id` (`quickbooks_ticket_id`),
  KEY `batch` (`batch`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quickbooks_oauth`
--

CREATE TABLE `quickbooks_oauth` (
  `quickbooks_oauth_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_username` varchar(255) NOT NULL,
  `app_tenant` varchar(255) NOT NULL,
  `oauth_request_token` varchar(255) DEFAULT NULL,
  `oauth_request_token_secret` varchar(255) DEFAULT NULL,
  `oauth_access_token` varchar(255) DEFAULT NULL,
  `oauth_access_token_secret` varchar(255) DEFAULT NULL,
  `qb_realm` varchar(32) DEFAULT NULL,
  `qb_flavor` varchar(12) DEFAULT NULL,
  `qb_user` varchar(64) DEFAULT NULL,
  `request_datetime` datetime NOT NULL,
  `access_datetime` datetime DEFAULT NULL,
  `touch_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`quickbooks_oauth_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quickbooks_queue`
--

CREATE TABLE `quickbooks_queue` (
  `quickbooks_queue_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quickbooks_ticket_id` int(10) unsigned DEFAULT NULL,
  `qb_username` varchar(40) NOT NULL,
  `qb_action` varchar(32) NOT NULL,
  `ident` varchar(40) NOT NULL,
  `extra` text,
  `qbxml` text,
  `priority` int(10) unsigned DEFAULT '0',
  `qb_status` char(1) NOT NULL,
  `msg` text,
  `enqueue_datetime` datetime NOT NULL,
  `dequeue_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`quickbooks_queue_id`),
  KEY `quickbooks_ticket_id` (`quickbooks_ticket_id`),
  KEY `priority` (`priority`),
  KEY `qb_username` (`qb_username`,`qb_action`,`ident`,`qb_status`),
  KEY `qb_status` (`qb_status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quickbooks_recur`
--

CREATE TABLE `quickbooks_recur` (
  `quickbooks_recur_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qb_username` varchar(40) NOT NULL,
  `qb_action` varchar(32) NOT NULL,
  `ident` varchar(40) NOT NULL,
  `extra` text,
  `qbxml` text,
  `priority` int(10) unsigned DEFAULT '0',
  `run_every` int(10) unsigned NOT NULL,
  `recur_lasttime` int(10) unsigned NOT NULL,
  `enqueue_datetime` datetime NOT NULL,
  PRIMARY KEY (`quickbooks_recur_id`),
  KEY `qb_username` (`qb_username`,`qb_action`,`ident`),
  KEY `priority` (`priority`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quickbooks_ticket`
--

CREATE TABLE `quickbooks_ticket` (
  `quickbooks_ticket_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qb_username` varchar(40) NOT NULL,
  `ticket` char(36) NOT NULL,
  `processed` int(10) unsigned DEFAULT '0',
  `lasterror_num` varchar(32) DEFAULT NULL,
  `lasterror_msg` varchar(255) DEFAULT NULL,
  `ipaddr` char(15) NOT NULL,
  `write_datetime` datetime NOT NULL,
  `touch_datetime` datetime NOT NULL,
  PRIMARY KEY (`quickbooks_ticket_id`),
  KEY `ticket` (`ticket`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quickbooks_user`
--

CREATE TABLE `quickbooks_user` (
  `qb_username` varchar(40) NOT NULL,
  `qb_password` varchar(255) NOT NULL,
  `qb_company_file` varchar(255) DEFAULT NULL,
  `qbwc_wait_before_next_update` int(10) unsigned DEFAULT '0',
  `qbwc_min_run_every_n_seconds` int(10) unsigned DEFAULT '0',
  `status` char(1) NOT NULL,
  `write_datetime` datetime NOT NULL,
  `touch_datetime` datetime NOT NULL,
  PRIMARY KEY (`qb_username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `system_requests`
--

CREATE TABLE `system_requests` (
  `system_requests_id` int(10) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `current_path` longtext NOT NULL,
  `user_agent` longtext NOT NULL,
  `get_request` longtext NOT NULL,
  `post_request` longtext NOT NULL,
  `session_request` longtext NOT NULL,
  `cookie_request` longtext NOT NULL,
  `request_made_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`system_requests_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_admin_menu`
--

CREATE TABLE `tsm_admin_menu` (
  `menu_item_id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `target` varchar(255) NOT NULL DEFAULT '_self',
  PRIMARY KEY (`menu_item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_admin_users`
--

CREATE TABLE `tsm_admin_users` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(65) NOT NULL,
  `website_id` int(10) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `website_id` (`website_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_components`
--

CREATE TABLE `tsm_components` (
  `component_id` int(10) NOT NULL AUTO_INCREMENT,
  `component_name` varchar(255) NOT NULL,
  PRIMARY KEY (`component_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_config`
--

CREATE TABLE `tsm_config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `config_option` varchar(255) NOT NULL,
  `config_value` varchar(255) NOT NULL,
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_customers`
--

CREATE TABLE `tsm_customers` (
  `customer_id` int(10) NOT NULL AUTO_INCREMENT,
  `organization_name` varchar(255) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_options`
--

CREATE TABLE `tsm_options` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(255) NOT NULL,
  `option_value` longtext NOT NULL,
  `website_id` int(11) NOT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_page_pages`
--

CREATE TABLE `tsm_page_pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` varchar(255) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `website_id` int(11) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_campuses`
--

CREATE TABLE `tsm_reg_campuses` (
  `campus_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `payment_address_attn` varchar(50) NOT NULL,
  `payment_address` varchar(100) NOT NULL,
  `payment_address2` varchar(50) NOT NULL,
  `payment_city` varchar(50) NOT NULL,
  `payment_state` varchar(2) NOT NULL,
  `payment_zip` int(5) NOT NULL,
  `quickbooks_enabled` tinyint(1) NOT NULL,
  `quickbooks_ms_connection_ticket` varchar(255) NOT NULL,
  `qb_paypal_payment_method_id` varchar(255) NOT NULL,
  `paypal_email` varchar(255) NOT NULL,
  `paypal_convenience_fee_id` int(10) NOT NULL,
  `registration_confirmation_email` longtext NOT NULL,
  `tuition_fee_type_id` int(11) NOT NULL,
  `registration_fee_type_id` int(11) NOT NULL,
  `registration_review_footnote` longtext NOT NULL,
  `pay_by_mail_message` longtext NOT NULL,
  `current_school_year` year(4) NOT NULL,
  `registration_open` tinyint(1) NOT NULL,
  `website_id` int(10) NOT NULL,
  PRIMARY KEY (`campus_id`),
  KEY `website_id` (`website_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_courses`
--

CREATE TABLE `tsm_reg_courses` (
  `course_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `course_number` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `school_year` year(4) NOT NULL,
  `campus_id` int(10) NOT NULL,
  `website_id` int(10) NOT NULL,
  `old_course_id` int(11) NOT NULL,
  PRIMARY KEY (`course_id`),
  KEY `website_id` (`website_id`),
  KEY `campus_id` (`campus_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_course_fee`
--

CREATE TABLE `tsm_reg_course_fee` (
  `course_fee_id` int(10) NOT NULL AUTO_INCREMENT,
  `course_id` int(10) NOT NULL,
  `program_id` int(10) DEFAULT NULL,
  `fee_id` int(10) NOT NULL,
  `old_course_fee_id` int(11) NOT NULL,
  PRIMARY KEY (`course_fee_id`),
  KEY `course_id` (`course_id`),
  KEY `program_id` (`program_id`),
  KEY `fee_id` (`fee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_course_fee_condition`
--

CREATE TABLE `tsm_reg_course_fee_condition` (
  `course_fee_condition_id` int(10) NOT NULL AUTO_INCREMENT,
  `course_id` int(10) NOT NULL,
  `program_id` int(10) DEFAULT NULL,
  `fee_id` int(10) NOT NULL,
  `fee_condition_id` int(10) NOT NULL,
  `old_course_fee_condition_id` int(11) NOT NULL,
  PRIMARY KEY (`course_fee_condition_id`),
  KEY `course_id` (`course_id`,`program_id`,`fee_id`,`fee_condition_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_course_period`
--

CREATE TABLE `tsm_reg_course_period` (
  `course_period_id` int(10) NOT NULL AUTO_INCREMENT,
  `course_id` int(10) NOT NULL,
  `period_id` int(10) NOT NULL,
  `teacher_id` int(10) NOT NULL,
  `old_course_period_id` int(11) NOT NULL,
  PRIMARY KEY (`course_period_id`),
  KEY `course_id` (`course_id`,`period_id`,`teacher_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_course_program`
--

CREATE TABLE `tsm_reg_course_program` (
  `course_program_id` int(10) NOT NULL AUTO_INCREMENT,
  `course_id` int(10) NOT NULL,
  `program_id` int(10) NOT NULL,
  `old_course_program_id` int(11) NOT NULL,
  PRIMARY KEY (`course_program_id`),
  KEY `class_id` (`course_id`,`program_id`),
  KEY `course_id` (`course_id`,`program_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_course_requirements`
--

CREATE TABLE `tsm_reg_course_requirements` (
  `course_requirement_id` int(10) NOT NULL AUTO_INCREMENT,
  `course_id` int(10) NOT NULL,
  `program_id` int(10) DEFAULT NULL,
  `requirement_id` int(10) NOT NULL,
  `old_course_requirement_id` int(11) NOT NULL,
  PRIMARY KEY (`course_requirement_id`),
  KEY `course_id` (`course_id`,`program_id`,`requirement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_families`
--

CREATE TABLE `tsm_reg_families` (
  `family_id` int(10) NOT NULL AUTO_INCREMENT,
  `father_first` varchar(255) NOT NULL,
  `father_last` varchar(255) NOT NULL,
  `mother_first` varchar(255) NOT NULL,
  `mother_last` varchar(255) NOT NULL,
  `primary_email` varchar(96) NOT NULL,
  `secondary_email` varchar(96) NOT NULL,
  `primary_phone` varchar(32) NOT NULL,
  `father_cell` varchar(32) NOT NULL,
  `mother_cell` varchar(32) NOT NULL,
  `secondary_phone` varchar(32) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zip` int(5) NOT NULL,
  `referral` varchar(255) NOT NULL,
  `password` varchar(65) NOT NULL,
  `quickbooks_customer_id` varchar(255) DEFAULT NULL,
  `campus_id` int(10) NOT NULL,
  `website_id` int(10) NOT NULL,
  `registration_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`family_id`),
  KEY `website_id` (`website_id`),
  KEY `campus_id` (`campus_id`,`website_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_families_fees`
--

CREATE TABLE `tsm_reg_families_fees` (
  `family_fee_id` int(10) NOT NULL AUTO_INCREMENT,
  `family_id` int(11) NOT NULL,
  `student_id` int(10) NOT NULL,
  `program_id` int(10) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `fee_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `fee_type_id` int(10) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `family_payment_plan_id` int(11) DEFAULT NULL,
  `school_year` year(4) NOT NULL,
  `time_assigned` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`family_fee_id`),
  KEY `family_id` (`family_id`,`student_id`,`program_id`,`course_id`,`fee_id`,`fee_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_families_invoices`
--

CREATE TABLE `tsm_reg_families_invoices` (
  `family_invoice_id` int(10) NOT NULL AUTO_INCREMENT,
  `family_id` int(10) NOT NULL,
  `invoice_description` varchar(255) NOT NULL,
  `quickbooks_invoice_id` varchar(255) NOT NULL,
  `quickbooks_external_key` varchar(255) NOT NULL,
  `quickbooks_doc_number` varchar(255) NOT NULL,
  `family_payment_plan_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `displayed` tinyint(1) NOT NULL DEFAULT '1',
  `invoice_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`family_invoice_id`),
  KEY `family_id` (`family_id`,`family_payment_plan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_families_invoice_fees`
--

CREATE TABLE `tsm_reg_families_invoice_fees` (
  `family_invoice_fee_id` int(10) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `family_id` int(10) NOT NULL,
  `family_fee_id` int(10) DEFAULT NULL,
  `family_invoice_id` int(10) NOT NULL,
  PRIMARY KEY (`family_invoice_fee_id`),
  KEY `family_id` (`family_id`,`family_fee_id`,`family_invoice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_families_payments`
--

CREATE TABLE `tsm_reg_families_payments` (
  `family_payment_id` int(10) NOT NULL AUTO_INCREMENT,
  `family_id` int(11) NOT NULL,
  `payment_description` varchar(255) NOT NULL,
  `reference_number` varchar(255) NOT NULL,
  `quickbooks_payment_id` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`family_payment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_families_payment_invoice`
--

CREATE TABLE `tsm_reg_families_payment_invoice` (
  `payment_invoice_id` int(10) NOT NULL AUTO_INCREMENT,
  `family_payment_id` int(10) NOT NULL,
  `family_invoice_id` int(10) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`payment_invoice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_families_payment_plans`
--

CREATE TABLE `tsm_reg_families_payment_plans` (
  `family_payment_plan_id` int(10) NOT NULL AUTO_INCREMENT,
  `family_id` int(10) NOT NULL,
  `payment_plan_id` int(10) NOT NULL,
  `fee_types` varchar(255) NOT NULL,
  `fee_type_id` int(10) NOT NULL,
  `accept_disclaimer` tinyint(1) NOT NULL,
  `setup_complete` tinyint(1) NOT NULL,
  `school_year` int(10) NOT NULL,
  `time_assigned` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`family_payment_plan_id`),
  KEY `family_id` (`family_id`,`payment_plan_id`,`fee_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_families_school_years`
--

CREATE TABLE `tsm_reg_families_school_years` (
  `family_school_year_id` int(10) NOT NULL AUTO_INCREMENT,
  `family_id` int(10) NOT NULL,
  `returning_family` tinyint(1) NOT NULL,
  `current_step` int(10) NOT NULL DEFAULT '1',
  `payment_plans` varchar(255) DEFAULT NULL,
  `school_year` year(4) NOT NULL,
  `registration_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`family_school_year_id`),
  KEY `family_id` (`family_id`,`school_year`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_fees`
--

CREATE TABLE `tsm_reg_fees` (
  `fee_id` int(10) NOT NULL AUTO_INCREMENT,
  `fee_type_id` int(10) NOT NULL,
  `quickbooks_item_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `school_year` year(4) NOT NULL,
  `campus_id` int(10) NOT NULL,
  `website_id` int(10) NOT NULL,
  `old_fee_id` int(11) NOT NULL,
  PRIMARY KEY (`fee_id`),
  KEY `website_id` (`website_id`),
  KEY `fee_type_id` (`fee_type_id`,`campus_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_fee_conditions`
--

CREATE TABLE `tsm_reg_fee_conditions` (
  `fee_condition_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `config_1` varchar(255) NOT NULL,
  `config_2` varchar(255) NOT NULL,
  `config_3` varchar(255) NOT NULL,
  `config_4` varchar(255) NOT NULL,
  `config_5` varchar(255) NOT NULL,
  `config_6` varchar(255) NOT NULL,
  `fee_condition_type_id` int(10) NOT NULL,
  `school_year` year(4) NOT NULL,
  `campus_id` int(10) NOT NULL,
  `website_id` int(10) NOT NULL,
  `old_fee_condition_id` int(11) NOT NULL,
  PRIMARY KEY (`fee_condition_id`),
  KEY `website_id` (`website_id`),
  KEY `campus_id` (`campus_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_fee_condition_types`
--

CREATE TABLE `tsm_reg_fee_condition_types` (
  `fee_condition_type_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`fee_condition_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_fee_payment_plans`
--

CREATE TABLE `tsm_reg_fee_payment_plans` (
  `payment_plan_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `disclaimer` longtext NOT NULL,
  `fee_type_id` int(10) DEFAULT NULL,
  `payment_plan_type_id` int(10) NOT NULL,
  `immediate_invoice_percentage` int(10) NOT NULL,
  `start_date` date NOT NULL,
  `invoice_frequency` int(2) NOT NULL,
  `num_invoices` int(2) NOT NULL,
  `installment_fee_id` int(10) NOT NULL,
  `installment_description` varchar(255) NOT NULL,
  `invoice_and_credit` tinyint(1) NOT NULL,
  `credit_fee_id` int(10) NOT NULL,
  `credit_description` varchar(255) NOT NULL,
  `campus_id` int(10) NOT NULL,
  `website_id` int(10) NOT NULL,
  `school_year` year(4) NOT NULL,
  `old_payment_plan_id` int(11) NOT NULL,
  PRIMARY KEY (`payment_plan_id`),
  KEY `fee_type_id` (`fee_type_id`,`campus_id`,`website_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_fee_types`
--

CREATE TABLE `tsm_reg_fee_types` (
  `fee_type_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `campus_id` int(11) NOT NULL,
  `website_id` int(11) NOT NULL,
  `school_year` year(4) NOT NULL,
  `old_fee_type_id` int(11) NOT NULL,
  PRIMARY KEY (`fee_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_periods`
--

CREATE TABLE `tsm_reg_periods` (
  `period_id` int(10) NOT NULL AUTO_INCREMENT,
  `day` tinyint(1) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `school_year` year(4) NOT NULL,
  `campus_id` int(10) NOT NULL,
  `website_id` int(10) NOT NULL,
  `old_period_id` int(11) NOT NULL,
  PRIMARY KEY (`period_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_programs`
--

CREATE TABLE `tsm_reg_programs` (
  `program_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `icon_url` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `school_year` year(4) NOT NULL,
  `campus_id` int(10) NOT NULL,
  `website_id` int(10) NOT NULL,
  `old_program_id` int(11) NOT NULL,
  PRIMARY KEY (`program_id`),
  KEY `website_id` (`website_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_program_fee`
--

CREATE TABLE `tsm_reg_program_fee` (
  `program_fee_id` int(10) NOT NULL AUTO_INCREMENT,
  `program_id` int(10) NOT NULL,
  `fee_id` int(10) NOT NULL,
  `old_program_fee_id` int(11) NOT NULL,
  PRIMARY KEY (`program_fee_id`),
  KEY `program_id` (`program_id`,`fee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_program_fee_condition`
--

CREATE TABLE `tsm_reg_program_fee_condition` (
  `program_fee_condition_id` int(10) NOT NULL AUTO_INCREMENT,
  `program_id` int(10) NOT NULL,
  `fee_id` int(10) NOT NULL,
  `fee_condition_id` int(10) NOT NULL,
  `old_program_fee_condition_id` int(11) NOT NULL,
  PRIMARY KEY (`program_fee_condition_id`),
  KEY `program_id` (`program_id`,`fee_id`,`fee_condition_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_program_requirements`
--

CREATE TABLE `tsm_reg_program_requirements` (
  `program_requirement_id` int(10) NOT NULL AUTO_INCREMENT,
  `program_id` int(11) NOT NULL,
  `requirement_id` int(11) NOT NULL,
  `old_program_requirement_id` int(11) NOT NULL,
  PRIMARY KEY (`program_requirement_id`),
  KEY `program_id` (`program_id`,`requirement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_requirements`
--

CREATE TABLE `tsm_reg_requirements` (
  `requirement_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `config_1` varchar(255) NOT NULL,
  `config_2` varchar(255) NOT NULL,
  `config_3` varchar(255) NOT NULL,
  `config_4` varchar(255) NOT NULL,
  `requirement_type_id` int(10) NOT NULL,
  `school_year` year(4) NOT NULL,
  `campus_id` int(10) NOT NULL,
  `website_id` int(11) NOT NULL,
  `old_requirement_id` int(11) NOT NULL,
  PRIMARY KEY (`requirement_id`),
  KEY `campus_id` (`campus_id`,`website_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_requirement_types`
--

CREATE TABLE `tsm_reg_requirement_types` (
  `requirement_type_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`requirement_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_school_years`
--

CREATE TABLE `tsm_reg_school_years` (
  `school_year_id` int(10) NOT NULL AUTO_INCREMENT,
  `school_year` year(4) NOT NULL,
  `campus_id` int(11) NOT NULL,
  PRIMARY KEY (`school_year_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_shirt_sizes`
--

CREATE TABLE `tsm_reg_shirt_sizes` (
  `shirt_size_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `campus_id` int(10) NOT NULL,
  `website_id` int(10) NOT NULL,
  `school_year` year(4) NOT NULL,
  `old_shirt_size_id` int(11) NOT NULL,
  PRIMARY KEY (`shirt_size_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_students`
--

CREATE TABLE `tsm_reg_students` (
  `student_id` int(10) NOT NULL AUTO_INCREMENT,
  `family_id` int(10) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `age` tinyint(2) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `shirt_size_id` int(10) DEFAULT NULL,
  `grade` tinyint(2) NOT NULL,
  `am_pm` varchar(2) NOT NULL,
  `campus_id` int(10) NOT NULL,
  `website_id` int(10) NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`student_id`),
  KEY `family_id` (`family_id`,`campus_id`,`website_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_students_school_years`
--

CREATE TABLE `tsm_reg_students_school_years` (
  `student_school_year_id` int(10) NOT NULL AUTO_INCREMENT,
  `student_id` int(10) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `first_year` tinyint(1) NOT NULL,
  `school_year` year(4) NOT NULL,
  `registration_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`student_school_year_id`),
  KEY `student_id` (`student_id`,`school_year`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_student_course`
--

CREATE TABLE `tsm_reg_student_course` (
  `student_course_id` int(10) NOT NULL AUTO_INCREMENT,
  `student_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `course_period_id` int(10) NOT NULL,
  `program_id` int(10) NOT NULL,
  `registration_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`student_course_id`),
  KEY `student_id` (`student_id`,`course_id`,`course_period_id`,`program_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_student_program`
--

CREATE TABLE `tsm_reg_student_program` (
  `student_program_id` int(10) NOT NULL AUTO_INCREMENT,
  `student_id` int(10) NOT NULL,
  `program_id` int(10) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`student_program_id`),
  KEY `student_id` (`student_id`,`program_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_teachers`
--

CREATE TABLE `tsm_reg_teachers` (
  `teacher_id` int(10) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `campus_id` int(10) NOT NULL,
  `website_id` int(10) NOT NULL,
  PRIMARY KEY (`teacher_id`),
  KEY `campus_id` (`campus_id`,`website_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_teachers_school_years`
--

CREATE TABLE `tsm_reg_teachers_school_years` (
  `teacher_school_year_id` int(10) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(10) NOT NULL,
  `school_year` year(4) NOT NULL,
  PRIMARY KEY (`teacher_school_year_id`),
  KEY `teacher_id` (`teacher_id`,`school_year`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_reg_users`
--

CREATE TABLE `tsm_reg_users` (
  `reg_user_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `super_user` tinyint(1) NOT NULL,
  `allowed_campuses` varchar(255) NOT NULL,
  PRIMARY KEY (`reg_user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_sliders`
--

CREATE TABLE `tsm_sliders` (
  `slider_id` int(11) NOT NULL AUTO_INCREMENT,
  `slider_type_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `website_id` int(11) NOT NULL,
  PRIMARY KEY (`slider_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_sliders_slides`
--

CREATE TABLE `tsm_sliders_slides` (
  `slide_id` int(11) NOT NULL AUTO_INCREMENT,
  `slider_id` int(11) NOT NULL,
  `background_image` varchar(255) NOT NULL,
  `thumbnail_image` varchar(255) NOT NULL,
  `thumbnail_caption` varchar(255) NOT NULL,
  `html` longtext NOT NULL,
  PRIMARY KEY (`slide_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tsm_websites`
--

CREATE TABLE `tsm_websites` (
  `website_id` int(10) NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) NOT NULL,
  `primary_url` varchar(255) NOT NULL,
  `template_id` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`website_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO tsm_config (config_option,config_value) VALUES("db_version",".01.000");