<?php

namespace AC\Controller\ColumnRequest;

use AC;

class Select extends AC\Controller\ColumnRequest {

	protected function get_column( AC\Request $request ) {
		return $this->column_factory->create( [
			'name'      => $request->get( 'type' ),
			'type'      => $request->get( 'type' ),
			'meta_type' => new AC\MetaType( $request->get( 'meta_type' ) ),
			'post_type' => $request->get( 'post_type' ),
			'taxonomy'  => $request->get( 'taxonomy' ),
			'list_key'  => $request->get( 'list_screen' )
		] );
	}

}