/* Header line. Object: tsm_customers. Script date: 4/24/2013 2:51:04 PM. */
DROP TABLE IF EXISTS `_temp_tsm_customers`;

CREATE TABLE `_temp_tsm_customers` (
  `customer_id` int(10) NOT NULL auto_increment,
  `organization_name` varchar(255) NOT NULL,
  PRIMARY KEY  ( `customer_id` )
)
  ENGINE = InnoDB
  CHARACTER SET = latin1
  AUTO_INCREMENT = 4
  ROW_FORMAT = Compact
;

INSERT INTO `_temp_tsm_customers`
( `customer_id` )
  SELECT
    `customer_id`
  FROM `tsm_customers`;

DROP TABLE `tsm_customers`;

ALTER TABLE `_temp_tsm_customers` RENAME `tsm_customers`;

/* Header line. Object: tsm_reg_families_invoices. Script date: 4/24/2013 2:51:04 PM. */
DROP TABLE IF EXISTS `_temp_tsm_reg_families_invoices`;

CREATE TABLE `_temp_tsm_reg_families_invoices` (
  `family_invoice_id` int(10) NOT NULL auto_increment,
  `family_id` int(10) NOT NULL,
  `quickbooks_invoice_id` varchar(255) NOT NULL,
  `quickbooks_external_key` varchar(255) NOT NULL,
  `quickbooks_doc_number` varchar(255) NOT NULL,
  `family_payment_plan_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `displayed` tinyint(1) NOT NULL default '1',
  `invoice_time` timestamp NOT NULL,
  KEY `family_id` ( `family_id`, `family_payment_plan_id` ),
  PRIMARY KEY  ( `family_invoice_id` )
)
  ENGINE = InnoDB
  CHARACTER SET = latin1
  AUTO_INCREMENT = 277
  ROW_FORMAT = Compact
;

INSERT INTO `_temp_tsm_reg_families_invoices`
( `amount`, `displayed`, `family_id`, `family_invoice_id`, `family_payment_plan_id`, `invoice_time`, `quickbooks_invoice_id` )
  SELECT
    `amount`, `displayed`, `family_id`, `family_invoice_id`, `family_payment_plan_id`, `invoice_time`, `quickbooks_invoice_id`
  FROM `tsm_reg_families_invoices`;

DROP TABLE `tsm_reg_families_invoices`;

ALTER TABLE `_temp_tsm_reg_families_invoices` RENAME `tsm_reg_families_invoices`;

/* Header line. Object: tsm_reg_families_payment_invoice. Script date: 4/24/2013 2:51:04 PM. */
CREATE TABLE `tsm_reg_families_payment_invoice` (
  `payment_invoice_id` int(10) NOT NULL auto_increment,
  `family_payment_id` int(10) NOT NULL,
  `family_invoice_id` int(10) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `last_updated` timestamp NOT NULL,
  PRIMARY KEY  ( `payment_invoice_id` )
)
  ENGINE = InnoDB
  CHARACTER SET = latin1
  AUTO_INCREMENT = 1
  ROW_FORMAT = Compact
;

/* Header line. Object: tsm_reg_families_payments. Script date: 4/24/2013 2:51:04 PM. */
CREATE TABLE `tsm_reg_families_payments` (
  `family_payment_id` int(10) NOT NULL auto_increment,
  `family_id` int(11) NOT NULL,
  `family_invoice_id` int(10) NOT NULL,
  `reference_number` varchar(255) NOT NULL,
  `quickbooks_payment_id` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_time` timestamp NOT NULL,
  KEY `family_invoice_id` ( `family_invoice_id` ),
  PRIMARY KEY  ( `family_payment_id` )
)
  ENGINE = InnoDB
  CHARACTER SET = latin1
  AUTO_INCREMENT = 1
  ROW_FORMAT = Compact
;


INSERT INTO tsm_reg_families_payments (family_payment_id,family_invoice_id,reference_number,quickbooks_payment_id,amount,payment_time)
    SELECT invoice_payment_id,family_invoice_id,paypal_transaction_id,quickbooks_payment_id,amount,payment_time FROM
      tsm_reg_families_invoice_payments;

UPDATE tsm_reg_families_payments fp, tsm_reg_families_invoices fi
SET fp.family_id = fi.family_id
WHERE fi.family_invoice_id = fp.family_invoice_id
      AND fp.family_invoice_id <> 0;
INSERT INTO tsm_reg_families_payment_invoice (family_payment_id,family_invoice_id,amount) SELECT fp.family_payment_id, fp.family_invoice_id, fp.amount FROM tsm_reg_families_payments fp WHERE fp.family_invoice_id <> 0;
UPDATE tsm_reg_families_payments SET family_invoice_id = 0 WHERE family_invoice_id <> 0;

-- Attention: Table `tsm_reg_families_invoice_payments` will be dropped.
DROP TABLE `tsm_reg_families_invoice_payments`;

ALTER TABLE `tsm_reg_families_payments` DROP `family_invoice_id`;