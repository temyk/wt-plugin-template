<?php
/** @var array $args */
?>
<div class="wrap">
    <h2><?php echo get_admin_page_title() ?></h2>
    <form action="<?= admin_url( 'options.php' ) ?>" method="POST">
		<?php
		settings_fields( MPN_PLUGIN_PREFIX . '_settings_group' );
		do_settings_sections( MPN_PLUGIN_PREFIX . '_settings_page' );
		submit_button();
		?>
    </form>
</div>
