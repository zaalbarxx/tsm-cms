RENAME TABLE  `tsm_components` TO  `tsm_modules` ;

TRUNCATE TABLE tsm_modules;

INSERT INTO `tsm_modules` (`component_id`, `component_name`) VALUES
(1, 'registration'),
(2, 'page'),
(3, 'slider'),
(4, 'edit'),
(5, 'welcome'),
(6, 'html_block');

ALTER TABLE  `tsm_modules` CHANGE  `component_id`  `module_id` INT( 10 ) NOT NULL AUTO_INCREMENT ,
CHANGE  `component_name`  `module_name` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

UPDATE  `tsm_config` SET  `config_value` =  '.01.001' WHERE  `tsm_config`.`config_id` =1;