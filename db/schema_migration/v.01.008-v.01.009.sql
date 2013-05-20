ALTER TABLE  `tsm_reg_families_invoices` ADD  `due_date` DATE NOT NULL AFTER  `invoice_and_credit`;

UPDATE tsm_reg_families_invoices SET due_date = invoice_time;

UPDATE tsm_reg_families_invoices SET due_date = '2013-05-01' WHERE invoice_description LIKE '%registration%';

UPDATE tsm_reg_families_invoices fi, tsm_reg_families_payment_plans fpp, tsm_reg_fee_payment_plans feepp
SET fi.invoice_description = 'Registration installment - (1 of 2)'
WHERE fi.invoice_description = 'Registration installment'
AND fi.family_payment_plan_id = fpp.family_payment_plan_id
AND fpp.payment_plan_id = feepp.payment_plan_id
AND (feepp.payment_plan_id = 42 OR feepp.payment_plan_id = 61 OR feepp.payment_plan_id = 64 OR feepp.payment_plan_id = 66);

UPDATE tsm_reg_campuses SET invoice_email_address = 'billing@artiosacademies.com';

UPDATE  `tsm_config` SET  `config_value` =  '.01.009' WHERE  `tsm_config`.`config_id` =1;