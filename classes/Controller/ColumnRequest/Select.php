<?php

namespace AC\Controller\ColumnRequest;

use AC;

class Select extends AC\Controller\ColumnRequest {

	protected function get_column( AC\Request $request, AC\ListScreen $list_screen ) {

		$columns = $list_screen->get_column_types();

		$type = $request->get( 'type' );

		return isset( $columns[ $type ] )
			? $columns[ $type ]
			: null;
	}

}