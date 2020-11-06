<?php

namespace AC;

class LegacyColumn {

	/**
	 * @var string Unique Name
	 */
	private $name;

	/**
	 * @var string Unique type
	 */
	// TODO: maybe remove?
	private $type;

	/**
	 * @var string Label which describes this column
	 */
	private $label;

	/**
	 * @var string Group name
	 */
	private $group;

	/**
	 * @var Settings\Column[]
	 */
	private $settings;

	/**
	 * @var Settings\FormatValue[]|Settings\FormatCollection[]
	 */
	private $formatters;

	/**
	 * The options managed by the settings
	 * @var array
	 */
	protected $options = [];

	public function __construct( $type, $name, $label, array $data = [] ) {
		$this->type = $type;
		$this->name = $name;
		$this->label = $label;
		$this->options = $data;
	}

	/**
	 * Get the unique name of the column
	 * @return string Column name
	 * @since 2.3.4
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * @param string $name
	 *
	 * @return $this
	 */
	public function set_name( $name ) {
		$this->name = (string) $name;

		return $this;
	}

	/**
	 * Get the type of the column.
	 * @return string Type
	 * @since 2.3.4
	 */
	public function get_type() {
		return $this->type;
	}

	public function get_group() {
		return $this->group;
	}

	/**
	 * @param Settings\Column $setting
	 *
	 * @return $this
	 */
	public function add_setting( Settings\Column $setting ) {
		$setting->set_values( $this->options );

		$this->settings[ $setting->get_name() ] = $setting;

		foreach ( (array) $setting->get_dependent_settings() as $dependent_setting ) {
			$this->add_setting( $dependent_setting );
		}

		return $this;
	}

	/**
	 * @param string $id Settings ID
	 */
	public function remove_setting( $id ) {
		if ( isset( $this->settings[ $id ] ) ) {
			unset( $this->settings[ $id ] );
		}
	}

	/**
	 * @param string $id
	 *
	 * @return Settings\Column|Settings\Column\User|Settings\Column\Separator|Settings\Column\Label
	 */
	public function get_setting( $id ) {
		return $this->get_settings()->get( $id );
	}

	public function get_formatters() {
		if ( null === $this->formatters ) {
			foreach ( $this->get_settings() as $setting ) {
				if ( $setting instanceof Settings\FormatValue || $setting instanceof Settings\FormatCollection ) {
					$this->formatters[] = $setting;
				}
			}
		}

		return $this->formatters;
	}

	/**
	 * @return string
	 * @since 3.2.5
	 */
	public function get_custom_label() {

		/**
		 * @param string $label
		 * @param Column $column
		 *
		 * @since 3.0
		 */
		return apply_filters( 'ac/headings/label', $this->get_setting( 'label' )->get_value(), $this );
	}

	/**
	 * @return Collection
	 */
	public function get_settings() {
		if ( null === $this->settings ) {
			$settings = [
				// TODO
				new Settings\Column\Label( $this ),
				new Settings\Column\Width( $this ),
			];

			foreach ( $settings as $setting ) {
				$this->add_setting( $setting );
			}

			$this->register_settings();

			do_action( 'ac/column/settings', $this );
		}

		return new Collection( $this->settings );
	}

	/**
	 * Register settings
	 */
	protected function register_settings() {
		// Overwrite in child class
	}

	/**
	 * @param string $key
	 *
	 * @return null|string|bool
	 */
	public function get_option( $key ) {
		$options = $this->get_options();

		return isset( $options[ $key ] ) ? $options[ $key ] : null;
	}

	/**
	 * Get the current options
	 * @return array
	 */
	public function get_options() {
		return $this->options;
	}

	/**
	 * Get the type of the column.
	 * @return string Label of column's type
	 * @since 2.4.9
	 */
	public function get_label() {
//		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return $this->label;
	}

	/**
	 * Enqueue CSS + JavaScript on the admin listings screen!
	 * This action is called in the admin_head action on the listings screen where your column values are displayed.
	 * Use this action to add CSS + JavaScript
	 * @since 2.3.4
	 */
	public function scripts() {
		// Overwrite in child class
	}

	/**
	 * Get the raw, underlying value for the column
	 * Not suitable for direct display, use get_value() for that
	 *
	 * @param int $id
	 *
	 * @return string|array
	 * @since 2.0.3
	 */
	public function get_raw_value( $id ) {
		return null;
	}

	/**
	 * @param string $type
	 *
	 * @return $this
	 */
	// TODO: deprecated
	public function set_type( $type ) {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		$this->type = (string) $type;

		return $this;
	}

	/**
	 * @param array $options
	 *
	 * @return $this
	 */
	public function set_options( array $options ) {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		$this->options = $options;

		return $this;
	}

	/**
	 * @param string $label
	 *
	 * @return $this
	 */
	// TODO: deprecated
	public function set_label( $label ) {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		$this->label = $label;

		return $this;
	}

	/**
	 * @param string $group Group label
	 *
	 * @return $this
	 */
	public function set_group( $group ) {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		$this->group = $group;

		return $this;
	}

	/**
	 * @return string
	 */
	// TODO: deprecate
	public function get_post_type() {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return null;
	}

	/**
	 * @return string
	 */
	// TODO: deprecate
	public function get_taxonomy() {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return null;
	}

	/**
	 * Return true when a default column has been replaced by a custom column.
	 * An original column will then use the original label and value.
	 * @since 3.0
	 */
	public function is_original() {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return $this->original;
	}

	/**
	 * @param bool $boolean
	 *
	 * @return $this
	 */
	public function set_original( $boolean ) {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		$this->original = (bool) $boolean;

		return $this;
	}

	/**
	 * Overwrite this function in child class.
	 * Determine whether this column type should be available
	 * @return bool Whether the column type should be available
	 * @since 2.2
	 */
	public function is_valid() {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return true;
	}

}