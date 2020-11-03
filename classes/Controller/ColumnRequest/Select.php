<?php

namespace AC\Controller\ColumnRequest;

use AC;

class Select extends AC\Controller\ColumnRequest {

	protected function get_column( AC\Request $request, AC\ListScreen $list_screen ) {
		return $this->column_factory->create( $request->get( 'list_screen' ), [
			'name'      => $request->get( 'type' ),
			'type'      => $request->get( 'type' ), // column type
			'meta_type' => new AC\MetaType( $request->get( 'meta_type' ) ),
			'post_type' => $request->get( 'post_type' ),
			'taxonomy'  => $request->get( 'taxonomy' ),
		] );
	}

}