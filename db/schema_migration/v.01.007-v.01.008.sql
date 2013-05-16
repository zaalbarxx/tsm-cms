ALTER TABLE  `tsm_reg_fee_payment_plans` CHANGE  `installment_description`  `installment_fee_description` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

ALTER TABLE  `tsm_reg_fee_payment_plans` CHANGE  `credit_description`  `credit_fee_description` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

ALTER TABLE  `tsm_reg_fee_payment_plans` ADD  `installment_invoice_description` VARCHAR( 255 ) NOT NULL AFTER  `qb_invoice_class_id`;

ALTER TABLE  `tsm_reg_fee_payment_plans` ADD  `credit_invoice_description` VARCHAR( 255 ) NOT NULL AFTER  `invoice_and_credit`;

ALTER TABLE  `tsm_reg_fee_payment_plans` ADD  `full_invoice_description` VARCHAR( 255 ) NOT NULL AFTER  `invoice_and_credit`;

/*UPDATE PAYMENT PLAN INVOICE NAMES*/
UPDATE tsm_reg_fee_payment_plans SET credit_invoice_description = CONCAT(name,' - Credit') WHERE (payment_plan_type_id = 2 OR payment_plan_type_id = 4);
UPDATE tsm_reg_fee_payment_plans SET full_invoice_description = CONCAT(name,' - Full Amount');
UPDATE tsm_reg_fee_payment_plans SET installment_invoice_description = installment_fee_description WHERE (payment_plan_type_id = 2 OR payment_plan_type_id = 4);

/*UPDATE INVOICE NAMES*/
UPDATE tsm_reg_families_invoices fi, tsm_reg_families_payment_plans fpp, tsm_reg_fee_payment_plans feepp SET fi.invoice_description = feepp.full_invoice_description WHERE fi.family_payment_plan_id = fpp.family_payment_plan_id AND feepp.payment_plan_id = fpp.payment_plan_id AND fi.amount > 0 AND fi.displayed = 0;
UPDATE tsm_reg_families_invoices fi, tsm_reg_families_payment_plans fpp, tsm_reg_fee_payment_plans feepp SET fi.invoice_description = feepp.credit_invoice_description WHERE fi.family_payment_plan_id = fpp.family_payment_plan_id AND feepp.payment_plan_id = fpp.payment_plan_id AND fi.amount < 0 AND fi.displayed = 0;
UPDATE tsm_reg_families_invoices fi, tsm_reg_families_payment_plans fpp, tsm_reg_fee_payment_plans feepp SET fi.invoice_description = feepp.installment_invoice_description WHERE fi.family_payment_plan_id = fpp.family_payment_plan_id AND feepp.payment_plan_id = fpp.payment_plan_id AND fi.amount > 0 AND fi.displayed = 1 AND (feepp.payment_plan_type_id = 2 OR feepp.payment_plan_type_id = 4);
UPDATE tsm_reg_families_invoices fi, tsm_reg_families_payment_plans fpp, tsm_reg_fee_payment_plans feepp SET fi.invoice_description = feepp.full_invoice_description WHERE fi.family_payment_plan_id = fpp.family_payment_plan_id AND feepp.payment_plan_id = fpp.payment_plan_id AND fi.amount > 0 AND fi.displayed = 1 AND (feepp.payment_plan_type_id = 1 OR feepp.payment_plan_type_id = 3);

ALTER TABLE  `tsm_reg_families_invoices` CHANGE  `family_payment_plan_id`  `family_payment_plan_id` INT( 11 ) NULL;

UPDATE  `tsm_config` SET  `config_value` =  '.01.008' WHERE  `tsm_config`.`config_id` =1;