# ClickTraq #
A lightweight click heat-mapping tool for websites.

Rather than hitting the server every time a user clicks somthing, this script instead counts them in memory and sends them to the server in a single post request when the exits the page. Heatmaps are drawn in browser using: https://github.com/pyalot/webgl-heatmap

This code is licenced uner the MIT licence, but is still in early development.

Currently only tested to work with chrome.

## Install table with

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