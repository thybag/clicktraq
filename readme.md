# ClickTraq #
A light weight click heatmapping tool for websites.


CREATE TABLE IF NOT EXISTS `page_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `webpage` varchar(255) NOT NULL,
  `time` varchar(60) NOT NULL,
  `screen_resolution` varchar(20) NOT NULL,
  `platform` varchar(50) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `total_clicks` int(11) NOT NULL,
  `visit_duration` int(11) NOT NULL,
  `clicks` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;