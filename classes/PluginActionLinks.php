<?php

namespace AC;

class PluginActionLinks implements Registrable {

	/**
	 * @var string
	 */
	private $basename;

	public function __construct( $basename ) {
		$this->basename = $basename;
	}

	public function register() {
		add_filter( 'plugin_action_links', [ $this, 'add_settings_link' ], 1, 2 );
		add_filter( 'network_admin_plugin_action_links', [ $this, 'add_settings_link' ], 1, 2 );
	}

	/**
	 * Add a settings link to the Admin Columns entry in the plugin overview screen
	 *
	 * @param array  $links
	 * @param string $file
	 *
	 * @return array
	 * @see   filter:plugin_action_links
	 * @since 1.0
	 */
	public function add_settings_link( $links, $file ) {
		if ( $file === $this->basename ) {
			array_unshift( $links, sprintf( '<a href="%s">%s</a>', esc_url( ac_get_admin_url( 'settings' ) ), __( 'Settings', 'codepress-admin-columns' ) ) );
		}

		$this->add_pro_link( $links );

		return $links;
	}

	/**
	 * @param array $links
	 *
	 * @return array
	 */
	private function add_pro_link( $links ) {
		if ( ! ac_is_pro_active() ) {
			$links[] = sprintf( '<a href="%s" target="_blank">%s</a>',
				esc_url( ac_get_site_utm_url( 'admin-columns-pro', 'upgrade' ) ),
				sprintf( '<span style="font-weight: bold;">%s</span>', __( 'Go Pro', 'codepress-admin-columns' ) )
			);
		}

		return $links;
	}

}