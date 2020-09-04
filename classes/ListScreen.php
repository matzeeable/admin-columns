<?php

namespace AC;

use AC\Type\ListScreenId;
use AC\Type\ListScreenKey;
use AC\Type\TableId;
use DateTime;
use ReflectionClass;
use ReflectionException;
use WP_Screen;

/**
 * List Screen
 * @since 2.0
 */
abstract class ListScreen implements Registrable {

	/**
	 * @deprecated 4.0
	 */
	const OPTIONS_KEY = 'cpac_options_';

	/**
	 * @var ListScreenId
	 */
	private $id;

	/**
	 * @var ListScreenKey
	 */
	protected $key;

	/**
	 * @var string
	 */
	protected $label;

	/**
	 * @var MetaType
	 */
	protected $meta_type;

	/**
	 * @var string
	 */
	private $singular_label;

	/**
	 * @var Column[]
	 */
	// TODO: use a ColumnCollection
	private $columns;

	/**
	 * @var Column[]
	 */
	// TODO
	private $column_types;

	/**
	 * @var DateTime
	 */
	private $updated;

	/**
	 * @var TableId
	 */
	protected $table_id;

	/**
	 * @var array ListScreen settings data
	 */
	private $preferences = [];

	/**
	 * @var bool True when column settings can not be overwritten
	 */
	private $read_only = false;

	/**
	 * @param ListScreenKey $key
	 * @param MetaType      $meta_type
	 * @param TableId       $table_id
	 * @param string        $label
	 */
	public function __construct(
		ListScreenKey $key,
		MetaType $meta_type,
		TableId $table_id,
		$label = null,
		ListScreenId $id = null
	) {
		$this->key = $key;
		$this->meta_type = $meta_type;
		$this->table_id = $table_id;
		$this->label = $label;
		$this->id = $id;
	}

	/**
	 * @return bool
	 */
	public function has_id() {
		return null !== $this->id;
	}

	/**
	 * @return ListScreenId
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * @return void
	 */
	abstract public function register();

	/**
	 * Register column types
	 * @return void
	 */
	abstract protected function register_column_types();

	/**
	 * @param int $id
	 *
	 * @return object
	 */
	abstract protected function get_object( $id );

	/**
	 * @return string
	 */
	abstract public function get_url();

	/**
	 * @return string
	 */
	public function get_key() {
		return $this->key->get_value();
	}

	/**
	 * @return TableId
	 */
	public function get_table_id() {
		return $this->table_id;
	}

	/**
	 * @return bool
	 */
	public function has_columns() {
		return null !== $this->columns;
	}

	/**
	 * @return string
	 */
	// TODO: what to do when empty?
	public function get_label() {
		return $this->label;
	}

	/**
	 * @return string
	 */
	// TODO: set Labels object?
	public function get_singular_label() {
		return null !== $this->singular_label ? $this->singular_label : $this->label;
	}

	/**
	 * @param string $label
	 *
	 * @return self
	 */
	protected function set_singular_label( $label ) {
		$this->singular_label = $label;

		return $this;
	}

	/**
	 * @return string
	 */
	public function get_meta_type() {
		return $this->meta_type->get();
	}

	/**
	 * @return string
	 */
	// TODO: deprecated
	public function get_title() {
		return $this->get_preference( 'title' );
	}

	public function set_id( ListScreenId $id ) {
		$this->id = $id;
	}

	/**
	 * ID attribute of targeted list table
	 * @return string
	 * @since 3.0
	 */
	public function get_table_attr_id() {
		return '#the-list';
	}

	/**
	 * Settings can not be overwritten
	 */
	public function is_read_only() {
		return $this->read_only;
	}

	/**
	 * @param bool $read_only
	 *
	 * @return $this
	 */
	public function set_read_only( $read_only ) {
		$this->read_only = (bool) $read_only;

		return $this;
	}

	/**
	 * @param DateTime $updated
	 *
	 * @return $this
	 */
	public function set_updated( DateTime $updated ) {
		$this->updated = $updated;

		return $this;
	}

	/**
	 * @return DateTime
	 */
	public function get_updated() {
		return $this->updated
			? $this->updated
			: new DateTime();
	}

	/**
	 * @return string
	 */
	// TODO: move to Columns page
	public function get_edit_link() {
		return add_query_arg( [
			'list_screen' => $this->key->get_value(),
			'layout_id'   => $this->id->get_id(),
		], ac_get_admin_url( 'columns' ) );
	}

	/**
	 * @return Column[]
	 * @since 3.0
	 */
	public function get_columns() {
		return $this->columns;
	}

	/**
	 * @return Column[]
	 */
	// TODO: refactor
	public function get_column_types() {
		if ( null === $this->column_types ) {
			$this->set_column_types();
		}

		return $this->column_types;
	}

	/**
	 * @param $name
	 *
	 * @return false|Column
	 * @since 2.0
	 */
	public function get_column_by_name( $name ) {
		$columns = $this->get_columns();

		foreach ( $columns as $column ) {
			// Do not do a strict comparision. All column names are stored as strings, even integers.
			if ( $column->get_name() == $name ) {
				return $column;
			}
		}

		return false;
	}

	/**
	 * @param string $type Column type
	 */
	public function deregister_column_type( $type ) {
		if ( isset( $this->column_types[ $type ] ) ) {
			unset( $this->column_types[ $type ] );
		}
	}

	/**
	 * @param Column $column
	 */
	public function register_column_type( Column $column ) {
		if ( ! $column->get_type() ) {
			return;
		}

		$column->set_list_screen( $this );

		// TODO: AC/Column::is_valid should accept a AC/ListScreen object
		if ( ! $column->is_valid() ) {
			return;
		}

		$repo = new DefaultColumnsRepository();

		if ( $column->is_original() && ! $repo->find( $this, $column->get_type() ) ) {
			return;
		}

		$this->column_types[ $column->get_type() ] = $column;
	}

	/**
	 * Available column types
	 */
	private function set_column_types() {
		$this->column_types = [];

		// Register default columns
		//		foreach ( $this->get_original_columns() as $type => $label ) {
		//
		//			// Ignore the mandatory checkbox column
		//			if ( 'cb' === $type ) {
		//				continue;
		//			}
		//
		//			$column = new Column();
		//
		//			$column
		//				->set_type( $type )
		//				->set_original( true );
		//
		//			$this->register_column_type( $column );
		//		}

		// Placeholder columns
		// TODO: add placeholders
		//		foreach ( new Integrations() as $integration ) {
		//			if ( ! $integration->show_placeholder( $this ) ) {
		//				continue;
		//			}
		//
		//			$plugin_info = new PluginInformation( $integration->get_basename() );
		//
		//			if ( $integration->is_plugin_active() && ! $plugin_info->is_active() ) {
		//				$column = new Placeholder();
		//				$column->set_integration( $integration );
		//
		//				$this->register_column_type( $column );
		//			}
		//		}

		// Load Custom columns
		$this->register_column_types();

		/**
		 * Register column types
		 *
		 * @param ListScreen $this
		 */
		do_action( 'ac/column_types', $this );
	}

	/**
	 * @param string $namespace
	 *
	 * @throws ReflectionException
	 */
	public function register_column_types_from_dir( $namespace ) {
		$classes = Autoloader::instance()->get_class_names_from_dir( $namespace );

		foreach ( $classes as $class ) {
			$reflection = new ReflectionClass( $class );

			if ( $reflection->isInstantiable() ) {
				$this->register_column_type( new $class );
			}
		}
	}

	/**
	 * @param string $column_name
	 */
	public function deregister_column( $column_name ) {
		unset( $this->columns[ $column_name ] );
	}

	public function add_column( Column $column ) {
		$this->columns[] = $column;
	}

	public function set_columns( array $columns ) {
		array_map( [ $this, 'add_column' ], $columns );
	}

	public function set_preferences( array $preferences ) {
		$this->preferences = $preferences;

		return $this;
	}

	/**
	 * @return array
	 */
	public function get_preferences() {
		return $this->preferences;
	}

	/**
	 * @param string $key
	 *
	 * @return mixed|null
	 */
	public function get_preference( $key ) {
		if ( ! isset( $this->preferences[ $key ] ) ) {
			return null;
		}

		return $this->preferences[ $key ];
	}

	/**
	 * @param string $column_name
	 * @param int    $id
	 * @param null   $original_value
	 *
	 * @return string
	 */
	// TODO: refactor
	public function get_display_value_by_column_name( $column_name, $id, $original_value = null ) {
		$column = $this->get_column_by_name( $column_name );

		// TODO: check Renderable interface

		if ( ! $column ) {
			return $original_value;
		}

		$value = $column->get_value( $id );

		// You can overwrite the display value for original columns by making sure get_value() does not return an empty string.
		if ( $column->is_original() && ac_helper()->string->is_empty( $value ) ) {
			return $original_value;
		}

		/**
		 * Column display value
		 *
		 * @param string $value  Column display value
		 * @param int    $id     Object ID
		 * @param Column $column Column object
		 *
		 * @since 3.0
		 */
		$value = apply_filters( 'ac/column/value', $value, $id, $column );

		return $value;
	}

	/**
	 * @return string
	 */
	public function get_screen_link() {
		return add_query_arg( [ 'layout' => $this->id->get_id() ], $this->get_url() );
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
		_deprecated_function( __METHOD__, 'NEWVERSION', 'AC\ListScreen::table_id::get_screen_id()' );

		return $this->table_id->get_screen_id();
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

		return $this->id->get_id();
	}

	/**
	 * @return string
	 * @deprecated NEWVERSION
	 */
	public function get_layout_id() {
		return $this->id->get_id();
	}

	/**
	 * @param string $layout_id
	 *
	 * @return self
	 * @deprecated NEWVERSION
	 */
	public function set_layout_id( $layout_id ) {
		_deprecated_function( __METHOD__, 'NEWVERSION', 'AC/ListScreen::set_id()' );

		$this->id = new ListScreenId( $layout_id );

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
	 * @return array
	 * @deprecated NEWVERSION
	 */
	public function get_settings() {
		_deprecated_function( __METHOD__, 'NEWVERSION', 'AC/ListScreen::get_columns()' );

		return [];
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
	 *
	 * @return object
	 * @deprecated 3.1.2
	 */
	protected function get_object_by_id( $id ) {
		_deprecated_function( __METHOD__, '3.1.4', 'AC\ListScreenWP::get_object()' );

		return $this->get_object( $id );
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