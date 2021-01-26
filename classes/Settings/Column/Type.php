<?php

namespace AC\Settings\Column;

use AC;
use AC\ColumnTypesRepository;
use AC\Groups;
use AC\Settings\Column;
use AC\View;

// TODO: move outside scope of Column objecct
class Type extends Column {

	const NAME = 'type';

	/**
	 * @var string
	 */
	private $type;

	/**
	 * @var string
	 */
	private $list_key;

	/**
	 * @var ColumnTypesRepository
	 */
	private $column_types_repository;

	/**
	 * @var string
	 */
	private $column_type;

	public function __construct( $column_type, $list_key ) {
		parent::__construct( self::NAME );

		$this->column_type = $column_type;
		$this->list_key = $list_key;

		// TODO
		$this->column_types_repository = new ColumnTypesRepository( new AC\DefaultColumnsRepository() );
	}

	public function create_view( $column_name ) {
		$type = $this
			->create_element( 'select', $column_name )
			->set_options( $this->get_grouped_columns() )
			->set_value( $this->column_type );

		// Tooltip
		$tooltip = __( 'Choose a column type.', 'codepress-admin-columns' );

		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			$tooltip .= '<em>' . __( 'Type', 'codepress-admin-columns' ) . ': ' . $this->column_type . '</em>';

			if ( $this->column_name ) {
				$tooltip .= '<em>' . __( 'Name', 'codepress-admin-columns' ) . ': ' . $this->column_name . '</em>';
			}
		}

		$view = new View( [
			'setting' => $type,
			'label'   => __( 'Type', 'codepress-admin-columns' ),
			'tooltip' => $tooltip,
		] );

		return $view;
	}

	/**
	 * Returns the type label as human readable: no tags, underscores and capitalized.
	 *
	 * @param string $label
	 * @param string $type
	 *
	 * @return string
	 */
	private function get_clean_label( $label, $type ) {
		if ( 0 === strlen( strip_tags( $label ) ) ) {
			$label = ucfirst( str_replace( '_', ' ', $type ) );
		}

		return strip_tags( $label );
	}

	/**
	 * @return Groups
	 */
	private function column_groups() {
		return AC\ColumnGroups::get_groups();
	}

	/**
	 * @return array
	 */
	private function get_grouped_columns() {
		$columns = [];

		// TODO: remove AC\Column::get_list_screen() dependency
		$column_types = $this->column_types_repository->find_all( [ ColumnTypesRepository::LIST_KEY => $this->list_key ] );

		foreach ( $column_types as $column ) {

			/**
			 * @param string $group Group slug
			 * @param Column $column
			 */
			$group = apply_filters( 'ac/column_group', $column->get_group(), $column );

			// Labels with html will be replaced by it's name.
			$columns[ $group ][ $column->get_key() ] = $this->get_clean_label( $column->get_label(), $column->get_key() );

			// TODO
//			if ( ! $column->is_original() ) {
//				natcasesort( $columns[ $group ] );
//			}
		}

		$grouped = [];

		// create select options
		foreach ( $this->column_groups()->get_groups_sorted() as $group ) {
			$slug = $group['slug'];

			// hide empty groups
			if ( ! isset( $columns[ $slug ] ) ) {
				continue;
			}

			if ( ! isset( $grouped[ $slug ] ) ) {
				$grouped[ $slug ]['title'] = $group['label'];
			}

			$grouped[ $slug ]['options'] = $columns[ $slug ];

			unset( $columns[ $slug ] );
		}

		// Add columns to a "default" group when it has an invalid group assigned
		foreach ( $columns as $group => $_columns ) {
			foreach ( $_columns as $name => $label ) {
				$grouped['default']['options'][ $name ] = $label;
			}
		}

		return $grouped;
	}

	/**
	 * @return string
	 */
	public function get_type() {
		return $this->type;
	}

}