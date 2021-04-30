<?php

namespace MPN;

class Settings {

	/**
	 * @var Plugin
	 */
	protected $plugin;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * Settings constructor.
	 *
	 */
	public function __construct() {
		$this->settings = $this->settings();

		add_action( 'admin_menu', [ $this, 'add_options_page' ] );
		add_action( 'admin_init', [ $this, 'init_settings' ] );
	}

	/**
	 * Array of the settings
	 *
	 * @return array
	 */
	public function settings() {
		$settings = [
			'settings_group' => [ //unique slug of the settings group
				'sections' => [
					[
						'title'   => __( 'General settings', 'plugin-slug' ),
						'slug'    => 'section_general',
						'options' => [
							'text_option'  => [
								'title'             => __( 'Text option', 'plugin-slug' ),
								'render_callback'   => [ $this, 'fill_text_field' ],
								'sanitize_callback' => [ $this, 'sanitize_callback' ],
							],
							'check_option' => [
								'title'             => __( 'Checkbox', 'plugin-slug' ),
								'render_callback'   => [ $this, 'fill_checkbox_field' ],
								'sanitize_callback' => [ $this, 'sanitize_callback' ],
							],
						],
					],
				]
			]
		];

		return $settings;
	}

	public function add_options_page() {
		add_options_page( __( 'My Plugin settings', 'plugin-slug' ), __( 'My Plugin', 'plugin-slug' ), 'manage_options', MPN_PLUGIN_PREFIX . '_page_slug', function () {
			echo Plugin::instance()->render_template( 'settings-page', [ 'settings' => $this->settings ] );
		} );
	}

	public function init_settings() {
		foreach ( $this->settings as $group_slug => $group ) {
			$group_slug = MPN_PLUGIN_PREFIX . '_' . $group_slug;
			foreach ( $group['sections'] as $section ) {
				$section_slug = MPN_PLUGIN_PREFIX . '_' . $section['slug'];
				foreach ( $section['options'] as $opt_name => $option ) {
					$opt_name = MPN_PLUGIN_PREFIX . '_' . $opt_name;
					register_setting( $group_slug, $opt_name, [
						'sanitize_callback' => $option['sanitize_callback'],
						'show_in_rest'      => false,
					] );
					add_settings_field( $opt_name, $option['title'], $option['render_callback'], MPN_PLUGIN_PREFIX . '_settings_page', $section_slug, $opt_name );
				}
				add_settings_section( $section_slug, $section['title'], '', MPN_PLUGIN_PREFIX . '_settings_page' );
			}
		}
	}

	/**
	 * @param $option_name
	 */
	function fill_text_field( $option_name ) {
		$val = get_option( $option_name );
		$val = $val ? $val : '';
		?>
        <input type="text" name="<?= $option_name; ?>" id="<?= $option_name; ?>"
               value="<?php echo esc_attr( $val ) ?>"/>
		<?php
	}

	/**
	 * @param $option_name
	 */
	function fill_checkbox_field( $option_name ) {
		$val   = get_option( $option_name );
		$val   = $val ? 1 : 0;
		$check = __( 'Check', 'plugin-slug' );
		?>
        <label for="<?= $option_name; ?>">
            <input type="checkbox" name="<?= $option_name; ?>" id="<?= $option_name; ?>"
                   value="<?= $val; ?>" <?php checked( 1, $val ) ?> />
			<?= $check; ?>
        </label>
		<?php
	}

	/**
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	function sanitize_callback( $value ) {
		if ( is_string( $value ) ) {
			return strip_tags( $value );
		}

		if ( is_numeric( $value ) ) {
			return intval( $value );
		}

		return $value;
	}
}