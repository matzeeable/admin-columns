<?php

namespace AC\Admin\Asset;

use AC;
use AC\Asset\Location;
use AC\Asset\Script;
use AC\DefaultColumnsRepository;
use AC\ListScreen;
use AC\ListScreenFactory;

class Columns extends Script {

	/**
	 * @var DefaultColumnsRepository
	 */
	private $default_columns;

	/**
	 * @var ListScreen
	 */
	private $list_screen;

	/**
	 * @var ListScreenFactory
	 */
	private $list_screen_factory;

	public function __construct(
		$handle,
		Location $location,
		DefaultColumnsRepository $default_columns,
		ListScreen $list_screen,
		ListScreenFactory $list_screen_factory
	) {
		parent::__construct( $handle, $location, [
			'jquery',
// TODO: causes console log error
//			'dashboard',
			'jquery-ui-slider',
			'jquery-ui-sortable',
			'wp-pointer',
		] );

		$this->default_columns = $default_columns;
		$this->list_screen = $list_screen;
		$this->list_screen_factory = $list_screen_factory;
	}

	private function get_list_screen_types() {
		return ( new AC\ListScreenTypeRepository() )->find_all( [ 'is_network' => is_network_admin() ] );
	}

	public function register() {
		parent::register();

		if ( null === $this->list_screen ) {
			return;
		}

		$params = [
			'_ajax_nonce'                => wp_create_nonce( AC\Ajax\Handler::NONCE_ACTION ),
			'list_screen'                => $this->list_screen->get_key(),
			'meta_type'                  => $this->list_screen->get_meta_type(),
			'post_type'                  => $this->list_screen instanceof AC\ListScreenPost ? $this->list_screen->get_post_type() : null,
			'taxonomy'                   => method_exists( $this->list_screen, 'get_taxonomy' ) ? $this->list_screen->get_taxonomy() : null,
			'layout'                     => $this->list_screen->has_id() ? $this->list_screen->get_id()->get_id() : null,
			'original_columns'           => [],
			'uninitialized_list_screens' => [],
			'i18n'                       => [
				'clone'  => __( '%s column is already present and can not be duplicated.', 'codepress-admin-columns' ),
				'error'  => __( 'Invalid response.', 'codepress-admin-columns' ),
				'errors' => [
					'save_settings'  => __( 'There was an error during saving the column settings.', 'codepress-admin-columns' ),
					'loading_column' => __( 'The column could not be loaded because of an unknown error', 'codepress-admin-columns' ),
				],
			],
		];

		foreach ( $this->get_list_screen_types() as $list_screen_type ) {
			if ( $this->default_columns->exists( $list_screen_type->get_key() ) ) {
				continue;
			}

			$params['uninitialized_list_screens'][ $list_screen_type->get_key() ] = [
				'screen_link' => add_query_arg( [ 'save-default-headings' => '1', 'list_screen' => $list_screen_type->get_key() ], $list_screen_type->get_url() ),
				'label'       => $list_screen_type->get_label(),
			];
		}

		wp_localize_script( 'ac-admin-page-columns', 'AC', $params );
	}

}