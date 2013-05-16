ALTER TABLE  `tsm_reg_campuses` ADD  `invoice_prefix` VARCHAR( 255 ) NOT NULL AFTER  `invoice_email_address`;

UPDATE tsm_reg_campuses SET invoice_prefix = 'AR';

UPDATE tsm_reg_families_invoices fi, tsm_reg_families f, tsm_reg_campuses c SET fi.quickbooks_doc_number = CONCAT(c.invoice_prefix,fi.family_invoice_id) WHERE c.campus_id = f.campus_id AND f.family_id = fi.family_id;

ALTER TABLE  `tsm_reg_families_invoices` CHANGE  `quickbooks_doc_number`  `doc_number` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

UPDATE  `tsm_config` SET  `config_value` =  '.01.007' WHERE  `tsm_config`.`config_id` =1;