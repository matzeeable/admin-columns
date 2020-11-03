<?php

namespace AC\Controller\ColumnRequest;

use AC;

class Refresh extends AC\Controller\ColumnRequest {

	protected function get_column( AC\Request $request, AC\ListScreen $list_screen ) {
		parse_str( $request->get( 'data' ), $formdata );
		$options = $formdata['columns'];
		$name = filter_input( INPUT_POST, 'column_name' );

		if ( empty( $options[ $name ] ) ) {
			wp_die();
		}

		$settings = $options[ $name ];

		$settings['name'] = $name;
		$settings['meta_type'] = new AC\MetaType( $request->get( 'meta_type' ) );
		$settings['post_type'] = $request->get( 'post_type' );
		$settings['taxonomy'] = $request->get( 'taxonomy' );

		return $this->column_factory->create( $request->get( 'list_screen' ), $settings );
	}

}