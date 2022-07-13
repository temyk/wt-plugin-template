<?php

namespace MPN;

class Page_Main extends PageBase {

	/**
	 * Settings constructor.
	 *
	 * @param $plugin Plugin Plugin class
	 */
	public function __construct( $plugin ) {
		parent::__construct( $plugin );

		$this->id                 = 'main';
		$this->page_menu_dashicon = 'dashicons-superhero-alt';
		$this->page_menu_position = 20;
		$this->page_title         = __( 'My Plugin Page', 'plugin-slug' );
		$this->page_menu_title    = __( 'My Plugin Page', 'plugin-slug' );

		add_action( 'admin_init', [ $this, 'init_settings' ] );
	}

	public function page_action() {
		$this->plugin->render_template( 'my-plugin-page', [ 'key' => 'value' ] );
	}
}
