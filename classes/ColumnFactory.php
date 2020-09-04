<?php

namespace AC;

class ColumnFactory {

	/**
	 * @var ColumnTypesRepository
	 */
	private $colummn_types_repository;

	// TODO: $column_types are registered to list screen. Refactor list screen?

	/**
	 * @param ColumnTypesRepository $colummn_types_repository
	 */
	public function __construct( ColumnTypesRepository $colummn_types_repository ) {

		// TODO decorate with Cached version
		$this->colummn_types_repository = $colummn_types_repository;
	}

	/**
	 * @param string     $column_name
	 * @param array      $data
	 * @param ListScreen $list_screen
	 *
	 * @return Column|null
	 */
	public function create( array $data, ListScreen $list_screen ) {
		if ( ! isset( $data['type'] ) ) {
			return null;
		}

		$type = $data['type'];

		$column_types = $this->colummn_types_repository->find( $list_screen );

		if ( ! isset( $column_types[ $type ] ) ) {
			return null;
		}

		/* @var Column $column_type */
		$column_type = $column_types[ $type ];

		$class = get_class( $column_type );

		/* @var Column $column */
		$column = new $class();
		$column->set_name( $data['name'] );
		$column->set_label( $data['label'] );
		$column->set_options( $data );
		$column->set_list_screen( $list_screen );

		if ( $column_type->is_original() ) {
			$column->set_original( true )->set_type( $data['name'] );
		}

		return $column;
	}

}