ALTER TABLE  `tsm_reg_families_invoices` ADD  `invoice_description` VARCHAR( 255 ) NOT NULL AFTER  `family_id`;

UPDATE tsm_reg_families_invoices fi, tsm_reg_families_payment_plans fpp, tsm_reg_fee_payment_plans feepp SET fi.invoice_description = feepp.name WHERE fi.family_payment_plan_id = fpp.family_payment_plan_id AND feepp.payment_plan_id = fpp.payment_plan_id;

ALTER TABLE  `tsm_reg_families_payments` ADD  `payment_description` VARCHAR( 255 ) NOT NULL AFTER  `family_id`;

UPDATE tsm_reg_families_payments fp, tsm_reg_families_payment_invoice fpi, tsm_reg_families_invoices fi, tsm_reg_families_payment_plans fpp, tsm_reg_fee_payment_plans feepp SET fp.payment_description = feepp.name WHERE fp.family_payment_id = fpi.family_payment_id AND fpi.family_invoice_id = fi.family_invoice_id AND fi.family_payment_plan_id = fpp.family_payment_plan_id AND fpp.payment_plan_id = feepp.payment_plan_id;