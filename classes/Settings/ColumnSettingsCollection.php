<?php
namespace AC\Settings;

use Iterator;

class ColumnSettingsCollection implements Iterator {

	/**
	 * @var Column[]
	 */
	private $settings;

	public function __construct( array $settings = [] ) {
		array_map( [ $this, 'set' ], $settings );
	}

	public function valid() {
		return ! in_array( $this->key(), [ null, false, '' ], true );
	}

	public function rewind() {
		reset( $this->settings );
	}

	public function first() {
		return reset( $this->settings );
	}

	public function current() {
		return current( $this->settings );
	}

	public function key() {
		return key( $this->settings );
	}

	public function next() {
		return next( $this->settings );
	}

	public function exists( $name ) {
		return isset( $this->settings[ $name ] );
	}

	public function get( $name ) {
		return $this->settings[ $name ];
	}

	public function set( Column $setting ) {
		$this->settings[ $setting->get_name() ] = $setting;
	}

	public function remove( $name ) {
		unset( $this->settings[ $name ] );
	}

}