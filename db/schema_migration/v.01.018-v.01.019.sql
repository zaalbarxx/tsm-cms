ALTER TABLE  `tsm_reg_families_fees` ADD  `installment_fee` TINYINT( 1 ) NOT NULL AFTER  `to_review`;

ALTER TABLE  `tsm_reg_families_fees` ADD  `credit_fee` TINYINT( 1 ) NOT NULL AFTER  `installment_fee`;

UPDATE tsm_reg_families_fees SET installment_fee = 1, credit_fee = 0 WHERE fee_id IN(
SELECT installment_fee_id FROM tsm_reg_fee_payment_plans
WHERE payment_plan_type_id = 2 OR payment_plan_type_id = 4)
AND amount >= 0;

UPDATE tsm_reg_families_fees SET installment_fee = 0, credit_fee = 1
WHERE fee_id IN(SELECT credit_fee_id FROM tsm_reg_fee_payment_plans
WHERE payment_plan_type_id = 2 OR payment_plan_type_id = 4)
AND amount < 0;

UPDATE  `tsm_config` SET  `config_value` =  '.01.019' WHERE  `tsm_config`.`config_id` =1;