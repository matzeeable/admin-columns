<?php

namespace AC\Controller\ListScreen;

use AC\ColumnFactory;
use AC\ListScreenFactory;
use AC\ListScreenRepository\Storage;
use AC\Request;
use AC\Type\ListScreenId;

class Save {

	/**
	 * @var Storage
	 */
	private $storage;

	/**
	 * @var ColumnFactory
	 */
	private $column_factory;

	/**
	 * @var ListScreenFactory
	 */
	private $list_screen_factory;

	public function __construct( Storage $storage, ColumnFactory $column_factory, ListScreenFactory $list_screen_factory ) {
		$this->storage = $storage;
		$this->column_factory = $column_factory;
		$this->list_screen_factory = $list_screen_factory;
	}

	public function request( Request $request ) {
		parse_str( $request->get( 'data' ), $formdata );

		if ( ! isset( $formdata['columns'] ) ) {
			wp_send_json_error( [ 'message' => __( 'You need at least one column', 'codepress-admin-columns' ) ] );
		}

		if ( ! ListScreenId::is_valid_id( $formdata['list_screen_id'] ) ) {
			wp_send_json_error( [ 'message' => 'Invalid list Id' ] );
		}

		$list_screen = $this->list_screen_factory->create( $formdata['list_screen'] );

		if ( ! $list_screen ) {
			wp_send_json_error( [ 'message' => 'List screen not found' ] );
		}

		$list_screen->set_id( new ListScreenId( $formdata['list_screen_id'] ) );

		foreach ( $formdata['columns'] as $column_name => $column_data ) {

			if ( isset( $column_data['label'] ) ) {
				$column_data['label'] = ac_convert_site_url( $column_data['label'] );
			}

			$column_data['name'] = false === strpos( $column_name, '_new_column_' )
				? $column_name
				: uniqid();

			$list_screen->add_column( $this->column_factory->create( $column_data, $list_screen ) );
		}

		$settings = isset( $formdata['settings'] ) && $formdata['settings']
			? $formdata['settings']
			: [];

		$settings['title'] = isset( $formdata['title'] ) && $formdata['title']
			? $formdata['title']
			: $list_screen->get_label();

		$list_screen->set_preferences( $settings );

		$this->storage->save( $list_screen );

		do_action( 'ac/columns_stored', $list_screen );

		wp_send_json_success(
			sprintf(
				'%s %s',
				sprintf(
					__( 'Settings for %s updated successfully.', 'codepress-admin-columns' ),
					sprintf( '<strong>%s</strong>', esc_html( $list_screen->get_title() ) )
				),
				sprintf( '<a href="%s">%s</a>', $list_screen->get_screen_link(), sprintf( __( 'View %s screen', 'codepress-admin-columns' ), $list_screen->get_label() ) )
			)
		);
	}

}