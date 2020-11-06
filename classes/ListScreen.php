<?php

namespace AC;

use AC\Type\ListScreenId;
use AC\Type\ListScreenLabel;
use AC\Type\Screen;
use DateTime;
use ReflectionException;

/**
 * List Screen
 * @since 2.0
 */
abstract class ListScreen extends ListScreenLegacy implements Registrable {

	/**
	 * @var MetaType
	 */
	protected $meta_type;

	/**
	 * @var Screen
	 */
	protected $screen;

	/**
	 * @var ListScreenLabel
	 */
	protected $label;

	/**
	 * @var ColumnCollection
	 */
	protected $columns;

	/**
	 * @var Column[]
	 */
	// TODO
	protected $column_types;

	/**
	 * @var DateTime
	 */
	protected $updated;

	/**
	 * @var ListScreenId
	 */
	protected $id;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * @var bool
	 */
	protected $read_only = false;

	/**
	 * @param MetaType $meta_type
	 * @param Screen $screen
	 * @param ListScreenLabel $label
	 * @param ColumnCollection $columns
	 * @param array $settings
	 * @param ListScreenId $id
	 */
	public function __construct(
		ColumnCollection $columns,
		MetaType $meta_type,
		Screen $screen,
		ListScreenLabel $label = null,
		array $settings = [],
		ListScreenId $id = null
	) {
		$this->columns = $columns;
		$this->meta_type = $meta_type;
		$this->screen = $screen;
		$this->label = $label;
		$this->settings = $settings;
		$this->id = $id;
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
	// TODO: remove
	abstract protected function get_table_url();

	/**
	 * @return ListScreenId
	 */
	public function get_id() {
		return $this->id;
	}

	public function get_key() {
		return $this->screen->get_key();
	}

	/**
	 * @return bool
	 */
	public function has_id() {
		return null !== $this->id;
	}

	/**
	 * @return Screen
	 */
	public function get_screen() {
		return $this->screen;
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

	// TODO: remove public
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
		return $this->get_setting( 'title' );
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
	 * @return ColumnCollection
	 * @since 3.0
	 */
	public function get_columns() {
		return $this->columns;
	}

	/**
	 * @return Column[]
	 */
	// TODO: refactor. obsolete.
//	public function get_column_types() {
//		if ( null === $this->column_types ) {
//			$this->set_column_types();
//		}
//
//		return $this->column_types;
//	}

	/**
	 * @param string $name
	 *
	 * @return Column null
	 * @since 2.0
	 */
	public function get_column_by_name( $name ) {
		return $this->columns->get( $name );
	}

	/**
	 * @param string $type Column type
	 */
//	public function deregister_column_type( $type ) {
//		if ( isset( $this->column_types[ $type ] ) ) {
//			unset( $this->column_types[ $type ] );
//		}
//	}

	/**
	 * @param Column $column
	 */
//	public function register_column_type( Column $column ) {
//		if ( ! $column->get_type() ) {
//			return;
//		}
//
//		$column->set_list_screen( $this );
//
//		// TODO: AC/Column::is_valid should accept a AC/ListScreen object
//		if ( ! $column->is_valid() ) {
//			return;
//		}
//
//		$repo = new DefaultColumnsRepository();
//
//		if ( $column->is_original() && ! $repo->find( $this->get_key(), $column->get_type() ) ) {
//			return;
//		}
//
//		$this->column_types[ $column->get_type() ] = $column;
//	}

	/**
	 * Available column types
	 */
//	private function set_column_types() {
//		$this->column_types = [];
//
//		// Load Custom columns
//		$this->register_column_types();
//
//		/**
//		 * Register column types
//		 *
//		 * @param ListScreen $this
//		 */
//		do_action( 'ac/column_types', $this );
//	}

	/**
	 * @param string $namespace
	 *
	 * @throws ReflectionException
	 */
//	public function register_column_types_from_dir( $namespace ) {
//		$classes = Autoloader::instance()->get_class_names_from_dir( $namespace );
//
//		foreach ( $classes as $class ) {
//			$reflection = new ReflectionClass( $class );
//
//			if ( $reflection->isInstantiable() ) {
//				$this->register_column_type( new $class );
//			}
//		}
//	}

	/**
	 * @param string $column_name
	 */
	// TODO: deprecate
	public function deregister_column( $column_name ) {
		unset( $this->columns[ $column_name ] );
	}

//	public function add_column( Column $column ) {
//		$this->columns->add( $column );
//	}
//
//	public function set_columns( ColumnCollection $columns ) {
//		$this->columns = $columns;
//	}

//	public function set_settings( array $settings ) {
//		$this->settings = $settings;
//	}

	/**
	 * @return array
	 */
	public function get_settings() {
		return $this->settings;
	}

	/**
	 * @param string $key
	 *
	 * @return null|mixed
	 */
	public function get_setting( $key ) {
		if ( ! isset( $this->settings[ $key ] ) ) {
			return null;
		}

		return $this->settings[ $key ];
	}

	/**
	 * @return string
	 */
	public function get_url() {
		return add_query_arg( [ 'layout' => $this->has_id() ? $this->id->get_id() : null ], $this->get_table_url() );
	}

	/**
	 * @param string $column_name
	 * @param int $id
	 * @param null $default
	 *
	 * @return string
	 */
	// TODO: refactor. unnecessary method.
	public function get_display_value_by_column_name( $column_name, $id, $default = null ) {
		$column = $this->columns->get( $column_name );

		if ( ! $column || ! $column instanceof Column\Renderable ) {
			return $default;
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
		return apply_filters( 'ac/column/value', $column->render( $id ), $id, $column );
	}

}