<?php

namespace AC\Controller\ColumnRequest;

use AC;
use AC\Settings\Column;

class Select extends AC\Controller\ColumnRequest {

	protected function get_column( AC\Request $request ) {
		return $this->column_factory->create( new AC\Type\ColumnData( [
			'name'             => $request->get( 'type' ),
			'meta_type'        => new AC\MetaType( $request->get( 'meta_type' ) ),
			'post_type'        => $request->get( 'post_type' ),
			'taxonomy'         => $request->get( 'taxonomy' ),
			'list_key'         => $request->get( 'list_screen' ),
			Column\Type::NAME  => $request->get( Column\Type::NAME ),
			Column\Label::NAME => $request->get( Column\Label::NAME )
		] ) );
	}

}