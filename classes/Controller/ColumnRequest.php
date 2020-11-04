<?php

namespace AC\Controller;

use AC;
use AC\Column\Placeholder;
use AC\View;

abstract class ColumnRequest {

	/**
	 * @var AC\ColumnFactory
	 */
	protected $column_factory;

	public function __construct( AC\ColumnFactory $column_factory ) {
		$this->column_factory = $column_factory;
	}

	/**
	 * @return AC\Column
	 */
	abstract protected function get_column( AC\Request $request );

	public function request( AC\Request $request ) {
		$column = $this->get_column( $request );

		$list_screen_type = ( new AC\ListScreenTypeRepository() )->find( $request->get( 'list_screen' ) );

		if ( ! $column ) {
			wp_send_json_error( [
				'type'  => 'message',
				'error' => sprintf( __( 'Please visit the %s screen once to load all available columns', 'codepress-admin-columns' ), ac_helper()->html->link( $list_screen_type->get_url(), $list_screen_type->get_label() ) ),
			] );
		}

		$current_original_columns = (array) $request->get( 'current_original_columns', [] );

		// Not cloneable message
		if ( in_array( $column->get_type(), $current_original_columns ) ) {
			wp_send_json_error( [
				'type'  => 'message',
				'error' => sprintf(
					__( '%s column is already present and can not be duplicated.', 'codepress-admin-columns' ),
					'<strong>' . $column->get_label() . '</strong>' ),
			] );
		}

		// Placeholder message
		if ( $column instanceof Placeholder ) {
			wp_send_json_error( [
				'type'  => 'message',
				'error' => $column->get_message(),
			] );
		}

		wp_send_json_success( $this->render_column( $column, $list_screen_type->get_key() ) );
	}

	/**
	 * @param AC\Column $column
	 *
	 * @return string
	 */
	private function render_column( AC\Column $column, $list_key ) {
		$view = new View( [
			'column'   => $column,
			'list_key' => $list_key,
		] );

		$view->set_template( 'admin/edit-column' );

		return $view->render();
	}

}