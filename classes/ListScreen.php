<?php

namespace AC;

use AC\Type\ListScreenId;
use AC\Type\ListScreenKey;
use AC\Type\ListScreenLabel;
use AC\Type\TableId;
use DateTime;
use ReflectionClass;
use ReflectionException;

/**
 * List Screen
 * @since 2.0
 */
abstract class ListScreen extends ListScreenLegacy implements Registrable {

	/**
	 * @var ListScreenKey
	 */
	protected $key;

	/**
	 * @var MetaType
	 */
	protected $meta_type;

	/**
	 * @var TableId
	 */
	protected $table_id;

	/**
	 * @var ListScreenLabel
	 */
	protected $label;

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
	 * @var ListScreenId
	 */
	private $id;

	/**
	 * @var array
	 */
	private $preferences = [];

	/**
	 * @var bool
	 */
	private $read_only = false;

	/**
	 * @param ListScreenKey $key
	 * @param MetaType $meta_type
	 * @param TableId $table_id
	 * @param ListScreenLabel $label
	 */
	public function __construct(
		ListScreenKey $key,
		MetaType $meta_type,
		TableId $table_id,
		ListScreenLabel $label = null,
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
	 * Register column types
	 * @return void
	 */
	// TODO: remove?
	abstract protected function register_column_types();

	/**
	 * @param int $id
	 *
	 * @return object
	 */
	// TODO: remove
	abstract protected function get_object( $id );

	/**
	 * @return string
	 */
	abstract protected function get_table_url();

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
	 * @return bool
	 */
	public function has_label() {
		return null !== $this->label;
	}

	/**
	 * @return ListScreenLabel
	 */
	public function get_label() {
		return $this->label;
	}

	/**
	 * @return string
	 */
	public function get_meta_type() {
		return $this->meta_type->get();
	}

	public function set_id( ListScreenId $id ) {
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function get_table_attr_id() {
		return '#the-list';
	}

	/**
	 * @return string
	 */
	public function get_title() {
		return $this->get_preference( 'title' );
	}

	/**
	 * @return bool
	 */
	public function is_read_only() {
		return $this->read_only;
	}

	/**
	 * @param bool $read_only
	 */
	public function set_read_only( $read_only ) {
		$this->read_only = (bool) $read_only;
	}

	// TODO: remove?
	public function set_updated( DateTime $updated ) {
		$this->updated = $updated;
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
	// TODO: move to ColumnCollection
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

	// TODO: rename set_settings()
	public function set_preferences( array $preferences ) {
		$this->preferences = $preferences;

		return $this;
	}

	/**
	 * @return array
	 */
	// TODO: rename get_settings()
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
	 * @param int $id
	 * @param null $original_value
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
		 * @param string $value Column display value
		 * @param int $id Object ID
		 * @param Column $column Column object
		 *
		 * @since 3.0
		 */
		$value = apply_filters( 'ac/column/value', $value, $id, $column );

		return $value;
	}

	public function get_url() {
		return add_query_arg( [ 'layout' => $this->id->get_id() ], $this->get_table_url() );
	}

}