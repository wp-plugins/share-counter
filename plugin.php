<?php

/*
  Plugin Name: Share Counter
  Plugin URI: http://wordpress.org/extend/plugins/share-counter/
  Author URI: http://www.kouratoras.gr
  Author: Konstantinos Kouratoras
  Contributors: kouratoras
  Tags: share, counter, facebook, twitter, googleplus
  Requires at least: 3.2
  Tested up to: 3.8
  Stable tag: 0.2
  Version: 0.2
  License: GPLv2 or later
  Description: Share Counter plugin displays a counter with the total shares from multiple social networks for the current page of your website using the sharedcount.com API.

  Copyright 2012 Konstantinos Kouratoras (kouratoras@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

define('PLUGIN_DIR_NAME', 'sharecounter');

class ShareCounter {
	/* -------------------------------------------------- */
	/* Constructor
	  /*-------------------------------------------------- */

	public function __construct() {

		load_plugin_textdomain('sharecounter-locale', false, plugin_dir_path(__FILE__) . '/lang/');
		
		//Widget
		require_once( plugin_dir_path(__FILE__) . '/plugin-widget.php' );
		add_action('widgets_init', create_function('', 'register_widget("ShareCounterWidget");'));
	}
}

new ShareCounter();