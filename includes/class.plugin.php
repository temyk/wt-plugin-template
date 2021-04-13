<?php

namespace MPN;

class Plugin {

	/**
	 * @var Settings
	 */
	public $settings;

	/**
	 * My Plugin constructor.
	 */
	public function __construct() {
		$this->settings = new Settings( $this );
		add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_assets' ] );
	}

	public function wp_enqueue_assets() {
		wp_enqueue_script( MPN_PLUGIN_PREFIX . '_js', MPN_PLUGIN_URL . "/assets/script.js", [ 'jquery' ], '', true );
	}

	/**
	 * Example function
	 */
	public function my_action() {
		$option = $this->settings->getOption( 'text_option' );
		echo $this->render_template( 'main', [ $option ] );
	}

	/**
	 * Method renders layout template
	 *
	 * @param string $template_name Template name without ".php"
	 * @param array $args Template arguments
	 *
	 * @return false|string
	 */
	public static function render_template( $template_name, $args = [] ) {
		$template_name = apply_filters( MPN_PLUGIN_PREFIX . '/template/name', $template_name, $args );

		$path = MPN_PLUGIN_DIR . "/templates/$template_name.php";
		if ( file_exists( $path ) ) {
			ob_start();
			include $path;

			return apply_filters( MPN_PLUGIN_PREFIX . '/content/template', ob_get_clean(), $template_name, $args );
		} else {
			return apply_filters( MPN_PLUGIN_PREFIX . '/message/template_not_found', 'This template does not exist!' );
		}
	}
}