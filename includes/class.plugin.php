<?php

namespace MPN;

/*
 * Main plugin class
 *
 * */

class Plugin extends Plugin_Base {

	/**
	 * Settings class
	 *
	 * @var Settings
	 */
	public $settings;

	/**
	 * Plugin constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->settings = new Settings();
	}

	public function front_enqueue_assets() {
		wp_enqueue_script( MPN_PLUGIN_PREFIX . '_js', MPN_PLUGIN_URL . "/assets/script.js", [ 'jquery' ], '', true );
	}

	/**
	 * Example function
	 */
	public function my_action() {
		$option = $this->getOption( 'text_option' );
		echo $this->render_template( 'main', [ $option ] );
	}

}