CREATE TABLE `tsm_sliders` (
  `slider_id` int(11) NOT NULL AUTO_INCREMENT,
  `slider_type_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `website_id` int(11) NOT NULL,
  PRIMARY KEY (`slider_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `tsm_sliders_slides` (
  `slide_id` int(11) NOT NULL AUTO_INCREMENT,
  `slider_id` int(11) NOT NULL,
  `background_image` varchar(255) NOT NULL,
  `thumbnail_image` varchar(255) NOT NULL,
  `thumbnail_caption` varchar(255) NOT NULL,
  `html` longtext NOT NULL,
  PRIMARY KEY (`slide_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
