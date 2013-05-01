ALTER TABLE tsm_websites ADD COLUMN default_admin_module INT( 10 ) NOT NULL AFTER title;

UPDATE  `tsm_config` SET  `config_value` =  '.01.002' WHERE  `tsm_config`.`config_id` =1;