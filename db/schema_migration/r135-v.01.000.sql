/* Header line. Object: tsm_config. Script date: 5/1/2013 11:26:54 AM. */
CREATE TABLE `tsm_config` (
	`config_id` int(11) NOT NULL auto_increment,
	`config_option` varchar(255) NOT NULL,
	`config_value` varchar(255) NOT NULL,
	PRIMARY KEY  ( `config_id` )
)
ENGINE = InnoDB
CHARACTER SET = latin1
AUTO_INCREMENT = 1
ROW_FORMAT = Compact
;

/* Header line. Object: tsm_options. Script date: 5/1/2013 11:26:54 AM. */
CREATE TABLE `tsm_options` (
	`option_id` int(11) NOT NULL auto_increment,
	`option_name` varchar(255) NOT NULL,
	`option_value` longtext NOT NULL,
	`website_id` int(11) NOT NULL,
	PRIMARY KEY  ( `option_id` )
)
ENGINE = InnoDB
CHARACTER SET = latin1
AUTO_INCREMENT = 1
ROW_FORMAT = Compact
;

/* Header line. Object: tsm_page_pages. Script date: 5/1/2013 11:26:54 AM. */
CREATE TABLE `tsm_page_pages` (
	`page_id` int(11) NOT NULL auto_increment,
	`guid` varchar(255) NOT NULL,
	`page_title` varchar(255) NOT NULL,
	`website_id` int(11) NOT NULL,
	PRIMARY KEY  ( `page_id` )
)
ENGINE = InnoDB
CHARACTER SET = latin1
AUTO_INCREMENT = 1
ROW_FORMAT = Compact
;

/* Header line. Object: tsm_sliders. Script date: 5/1/2013 11:26:54 AM. */
CREATE TABLE `tsm_sliders` (
	`slider_id` int(11) NOT NULL auto_increment,
	`slider_type_id` int(11) NOT NULL,
	`name` varchar(255) NOT NULL,
	`website_id` int(11) NOT NULL,
	PRIMARY KEY  ( `slider_id` )
)
ENGINE = InnoDB
CHARACTER SET = latin1
AUTO_INCREMENT = 1
ROW_FORMAT = Compact
;

/* Header line. Object: tsm_sliders_slides. Script date: 5/1/2013 11:26:54 AM. */
CREATE TABLE `tsm_sliders_slides` (
	`slide_id` int(11) NOT NULL auto_increment,
	`slider_id` int(11) NOT NULL,
	`background_image` varchar(255) NOT NULL,
	`thumbnail_image` varchar(255) NOT NULL,
	`thumbnail_caption` varchar(255) NOT NULL,
	`html` longtext NOT NULL,
	PRIMARY KEY  ( `slide_id` )
)
ENGINE = InnoDB
CHARACTER SET = latin1
AUTO_INCREMENT = 1
ROW_FORMAT = Compact
;

INSERT INTO tsm_config (config_option,config_value) VALUES("db_version",".01.000");