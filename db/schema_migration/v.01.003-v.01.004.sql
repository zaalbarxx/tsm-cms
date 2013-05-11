ALTER TABLE  `tsm_reg_program_fee` ADD  `quickbooks_class_id` VARCHAR( 255 ) NOT NULL AFTER  `fee_id`;

ALTER TABLE  `tsm_reg_course_fee` ADD  `quickbooks_class_id` VARCHAR( 255 ) NOT NULL AFTER  `fee_id`;

UPDATE  `tsm_config` SET  `config_value` =  '.01.004' WHERE  `tsm_config`.`config_id` =1;