<?php

namespace AC\Controller\ListScreen;

use AC\ListScreenRepository\Storage;
use AC\Request;
use AC\Type\ListScreenData;
use AC\Type\ListScreenId;

class Save {

	/**
	 * @var Storage
	 */
	private $storage;

	public function __construct( Storage $storage ) {
		$this->storage = $storage;
	}

	public function request( Request $request ) {
		parse_str( $request->get( 'data' ), $formdata );

		if ( ! isset( $formdata['columns'] ) ) {
			wp_send_json_error( [ 'message' => __( 'You need at least one column', 'codepress-admin-columns' ) ] );
		}

		if ( ! ListScreenId::is_valid_id( $formdata['list_screen_id'] ) ) {
			wp_send_json_error( [ 'message' => 'Invalid list Id' ] );
		}

		$data = [
			'id'       => $formdata['list_screen_id'],
			'key'      => $formdata['list_screen'],
			'title'    => 'Original',
			'settings' => [],
		];

		foreach ( $formdata['columns'] as $column_name => $column_data ) {

			if ( isset( $column_data['label'] ) ) {
				$column_data['label'] = ac_convert_site_url( $column_data['label'] );
			}

			$column_data['name'] = false === strpos( $column_name, '_new_column_' )
				? $column_name
				: uniqid();

			$data['columns'][ $column_data['name'] ] = $column_data;
		}

		if ( isset( $formdata['settings'] ) && $formdata['settings'] ) {
			$data['settings'] = $formdata['settings'];
		}

		if ( isset( $formdata['title'] ) && $formdata['title'] ) {
			$data['title'] = $formdata['title'];
		}

		// TODO
		$list_screen = $this->storage->save( new ListScreenData( $data ) );

		do_action( 'ac/columns_stored', $list_screen );

		wp_send_json_success(
			sprintf(
				'%s %s',
				sprintf(
					__( 'Settings for %s updated successfully.', 'codepress-admin-columns' ),
					sprintf( '<strong>%s</strong>', esc_html( $list_screen->get_title() ) )
				),
				sprintf( '<a href="%s">%s</a>', $list_screen->get_url(), sprintf( __( 'View %s screen', 'codepress-admin-columns' ), $list_screen->get_label() ) )
			)
		);
	}

}