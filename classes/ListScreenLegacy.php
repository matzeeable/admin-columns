<?php

namespace AC;

use AC\Type;
use AC\Type\ListScreenId;
use WP_Screen;

abstract class ListScreenLegacy {

	/**
	 * @deprecated 4.0
	 */
	const OPTIONS_KEY = 'cpac_options_';

	abstract public function get_id();

	abstract public function set_id( ListScreenId $id );

	/**
	 * @return Type\Screen
	 */
	abstract public function get_screen();

	/**
	 * @return void
	 */
	abstract public function register();

	public function get_preferences() {
		_deprecated_function( __METHOD__, 'NEWVERSION', 'AC/ListScreen::get_settings()' );

		return $this->get_settings();
	}

	/**
	 * @return string
	 */
	public function get_screen_link() {
		_deprecated_function( __METHOD__, 'NEWVERSION', 'AC\ListScreen::get_url()' );

		return $this->get_url();
	}

	/**
	 * @return string
	 */
	public function get_singular_label() {
		_deprecated_function( __METHOD__, 'NEWVERSION', 'AC\ListScreen::get_label()::get_single()' );

		return $this->label->get_single();
	}

	/**
	 * @param string $label
	 *
	 * @return self
	 */
	protected function set_singular_label( $label ) {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return $this;
	}

	/**
	 * @return string
	 * @deprecated NEWVERSION
	 */
	public function get_edit_link() {
		_deprecated_function( __METHOD__, 'NEWVERSION', 'ac_get_admin_columns_url()' );

		return ac_get_manage_columns_url( $this->get_id() );
	}

	/**
	 * @deprecated NEWVERSION
	 */
	public function set_manage_value_callback() {
		_deprecated_function( __METHOD__, 'NEWVERSION', 'AC\ListScreen::register()' );

		$this->register();
	}

	/**
	 * @param string $key
	 *
	 * @return self
	 * @deprecated NEWVERSION
	 */
	protected function set_key( $key ) {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return $this;
	}

	/**
	 * @return string
	 * @deprecated NEWVERSION
	 */
	public function get_group() {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return '';
	}

	/**
	 * @param string $group
	 *
	 * @return self
	 * @deprecated NEWVERSION
	 */
	public function set_group( $group ) {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return $this;
	}

	/**
	 * @param string $meta_type
	 *
	 * @return self
	 * @deprecated NEWVERSION
	 */
	protected function set_meta_type( $meta_type ) {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		$this->meta_type = new MetaType( $meta_type );

		return $this;
	}

	/**
	 * @param string $title
	 *
	 * @return $this
	 * @deprecated NEWVERSION
	 */
	public function set_title( $title ) {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return $this;
	}

	/**
	 * @param string $label
	 *
	 * @return self
	 * @deprecated NEWVERSION
	 */
	protected function set_label( $label ) {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return $this;
	}

	/**
	 * @return bool
	 * @deprecated NEWVERSION
	 */
	public function is_network_only() {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return false;
	}

	/**
	 * @param bool $network_only
	 *
	 * @deprecated NEWVERSION
	 */
	public function set_network_only( $network_only ) {
		_deprecated_function( __METHOD__, 'NEWVERSIO' );
	}

	/**
	 * @param array $columns
	 *
	 * @deprecated 4.0
	 */
	public function save_default_headings( $columns ) {
		_deprecated_function( __METHOD__, '4.0' );
	}

	/**
	 * @return array
	 * @deprecated 4.0
	 */
	public function get_stored_default_headings() {
		_deprecated_function( __METHOD__, '4.0' );

		return [];
	}

	/**
	 * @return void
	 */
	public function delete_default_headings() {
		_deprecated_function( __METHOD__, '4.0', 'AC\DefaultColumnsRepository()::delete( $key )' );

		( new DefaultColumnsRepository() )->delete( $this->get_key() );
	}

	/**
	 * @return bool
	 * @deprecated 4.0
	 */
	public function delete() {
		_deprecated_function( __METHOD__, '4.0' );

		return false;
	}

	/**
	 * @return string
	 */
	public function get_screen_id() {
		_deprecated_function( __METHOD__, 'NEWVERSION', 'AC\ListScreen::get_screen::get_id()' );

		return $this->get_screen()->get_id();
	}

	/**
	 * Get default column headers
	 * @return array
	 * @deprecated 4.0
	 */
	public function get_default_column_headers() {
		_deprecated_function( __METHOD__, '4.0' );

		return [];
	}

	/**
	 * Clears columns variable, which allow it to be repopulated by get_columns().
	 * @deprecated 4.0
	 * @since      2.5
	 */
	public function reset() {
		_deprecated_function( __METHOD__, '4.0' );
	}

	/**
	 * @deprecated 4.0
	 */
	public function populate_settings() {
		_deprecated_function( __METHOD__, '4.0' );
	}

	/**
	 * Reset original columns
	 * @deprecated 4.0
	 */
	public function reset_original_columns() {
		_deprecated_function( __METHOD__, '4.0' );
	}

	/**
	 * @param array $column_data
	 *
	 * @deprecated 4.0
	 */
	public function store( $column_data ) {
		_deprecated_function( __METHOD__, '4.0' );
	}

	/**
	 * @return string
	 * @deprecated NEWVERSION
	 */
	public function get_storage_key() {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return $this->get_id()->get_id();
	}

	/**
	 * @return string
	 * @deprecated NEWVERSION
	 */
	public function get_layout_id() {
		return $this->get_id()->get_id();
	}

	/**
	 * @param string $layout_id
	 *
	 * @return self
	 * @deprecated NEWVERSION
	 */
	public function set_layout_id( $layout_id ) {
		_deprecated_function( __METHOD__, 'NEWVERSION', 'AC/ListScreen::set_id()' );

		$this->set_id( new ListScreenId( $layout_id ) );

		return $this;
	}

	/**
	 * @param array $settings
	 *
	 * @return self
	 * @deprecated NEWVERSION
	 */
	public function set_settings( array $settings ) {
		_deprecated_function( __METHOD__, 'NEWVERSION', 'AC/ListScreen::set_columns()' );

		return $this;
	}

	/**
	 * @param Column $column
	 *
	 * @deprecated NEWVERSION
	 */
	protected function register_column( Column $column ) {
		_deprecated_function( __METHOD__, 'NEWVERSION', 'AC/ListScreen::add_column()' );

		$this->add_column( $column );
	}

	/**
	 * @return array
	 * @deprecated NEWVERSION
	 */
	public function get_original_columns() {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return [];
	}

	/**
	 * @param array $columns
	 *
	 * @deprecated NEWVERSION
	 */
	public function set_original_columns( $columns ) {
		_deprecated_function( __METHOD__, 'NEWVERSION' );
	}

	/**
	 * @return string
	 * @deprecated 3.1
	 */
	public function get_list_table_class() {
		_deprecated_function( __METHOD__, '3.1' );

		return '';
	}

	/**
	 * @param string $list_table_class
	 *
	 * @deprecated 3.1
	 */
	public function set_list_table_class( $list_table_class ) {
		_deprecated_function( __METHOD__, '3.1' );
	}

	/**
	 * @param int $id
	 */
	protected function get_object_by_id( $id ) {
		_deprecated_function( __METHOD__, '3.1.4' );
	}

	/**
	 * @return array [ $column_name => [ $orderby, $order ], ... ]
	 */
	public function get_default_sortable_columns() {
		_deprecated_function( __METHOD__, '4.0' );

		return [];
	}

	/**
	 * @param int $id
	 *
	 * @return string
	 * @deprecated NEWVERSION
	 */
	public function get_single_row( $id ) {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return '';
	}

	/**
	 * @deprecated NEWVERSION
	 */
	protected function get_list_table() {
		_deprecated_function( __METHOD__, 'NEWVERSION' );
	}

	/**
	 * @param WP_Screen $wp_screen
	 *
	 * @return boolean
	 * @deprecated NEWVERSION
	 */
	public function is_current_screen( WP_Screen $wp_screen ) {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return false;
	}

	/**
	 * @return string
	 * @deprecated NEWVERSION
	 */
	public function get_screen_base() {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return '';
	}

	/**
	 * @param string $screen_base
	 *
	 * @return self
	 * @deprecated NEWVERSION
	 */
	protected function set_screen_base( $screen_base ) {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return $this;
	}

	/**
	 * @param string $screen_id
	 *
	 * @return self
	 * @deprecated NEWVERSION
	 */
	protected function set_screen_id( $screen_id ) {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return $this;
	}

	/**
	 * @return string
	 * @deprecated NEWVERSION
	 */
	public function get_page() {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return '';
	}

	/**
	 * @param string $page
	 *
	 * @return self
	 * @deprecated NEWVERSION
	 */
	protected function set_page( $page ) {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return $this;
	}

	// TODO: remove. make 'public' deprecated.
	/**
	 * @param string $type Column type
	 *
	 * @return bool
	 */
	//	private function is_original_column( $type ) {
	//		$column = $this->get_column_by_type( $type );
	//
	//		if ( ! $column ) {
	//			return false;
	//		}
	//
	//		return $column->is_original();
	//	}

	/**
	 * @since 3.0
	 */
	//	private function _set_columns() {
	//		foreach ( $this->get_settings() as $name => $data ) {
	//			$data['name'] = $name;
	//			$column = $this->create_column( $data );
	//
	//			if ( $column ) {
	//				$this->register_column( $column );
	//			}
	//		}

	// Nothing stored. Use WP default columns.
	//		if ( null === $this->columns ) {
	//			foreach ( $this->get_original_columns() as $type => $label ) {
	//				if ( $column = $this->create_column( [ 'type' => $type, 'original' => true ] ) ) {
	//					$this->register_column( $column );
	//				}
	//			}
	//		}

	//		if ( null === $this->columns ) {
	//			$this->columns = [];
	//		}
	//	}

	/**
	 * @param array $settings Column options
	 *
	 * @return Column|false
	 */
	//	public function create_column( array $settings ) {
	//		if ( ! isset( $settings['type'] ) ) {
	//			return false;
	//		}
	//
	//		$class = $this->get_class_by_type( $settings['type'] );
	//
	//		if ( ! $class ) {
	//			return false;
	//		}
	//
	//		/* @var Column $column */
	//		$column = new $class();
	//		$column->set_list_screen( $this )
	//		       ->set_type( $settings['type'] );
	//
	//		if ( isset( $settings['name'] ) ) {
	//			$column->set_name( $settings['name'] );
	//		}
	//
	//		// Mark as original
	//		if ( $this->is_original_column( $settings['type'] ) ) {
	//			$column->set_original( true );
	//			$column->set_name( $settings['type'] );
	//		}
	//
	//		$column->set_options( $settings );
	//
	//		do_action( 'ac/list_screen/column_created', $column, $this );
	//
	//		return $column;
	//	}

	/**
	 * @param string $type
	 *
	 * @return false|Column
	 */
	//	public function get_column_by_type( $type ) {
	//		$column_types = $this->get_column_types();
	//
	//		if ( ! isset( $column_types[ $type ] ) ) {
	//			return false;
	//		}
	//
	//		return $column_types[ $type ];
	//	}

	/**
	 * @param string $type
	 *
	 * @return false|string
	 */
	//	public function get_class_by_type( $type ) {
	//		$column = $this->get_column_by_type( $type );
	//
	//		if ( ! $column ) {
	//			return false;
	//		}
	//
	//		return get_class( $column );
	//	}

	/**
	 * @param string $type
	 *
	 * @return string Label
	 */
	//	public function get_original_label( $type ) {
	//		$columns = $this->get_original_columns();
	//
	//		if ( ! isset( $columns[ $type ] ) ) {
	//			return false;
	//		}
	//
	//		return $columns[ $type ];
	//	}

	/**
	 * @return array
	 */

}