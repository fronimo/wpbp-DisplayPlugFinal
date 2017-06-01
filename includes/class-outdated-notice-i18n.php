<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://fsylumin.net
 * @since      1.0.0
 *
 * @package    Outdated_Notice
 * @subpackage Outdated_Notice/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Outdated_Notice
 * @subpackage Outdated_Notice/includes
 * @author     Alfre <alfredo@inka-labs.com>
 */
class Outdated_Notice_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'outdated-notice',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
