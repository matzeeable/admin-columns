<?php

namespace AC\Controller\ColumnRequest;

use AC;

class Select extends AC\Controller\ColumnRequest {

	/**
	 * @var AC\ColumnTypesRepository
	 */
	private $column_types_repository;

	public function __construct( AC\ColumnFactory $column_factory, AC\ColumnTypesRepository $column_types_repository ) {
		parent::__construct( $column_factory );

		$this->column_types_repository = $column_types_repository;
	}

	protected function get_column( AC\Request $request, AC\ListScreen $list_screen ) {

		$columns = $this->column_types_repository->find( $list_screen );

		$type = $request->get( 'type' );

		return isset( $columns[ $type ] )
			? $columns[ $type ]
			: null;
	}

}