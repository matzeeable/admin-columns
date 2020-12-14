<?php
namespace AC\Settings;

use ArrayAccess;
use InvalidArgumentException;
use Iterator;

class ColumnSettingsCollection implements ArrayAccess, Iterator {

	/**
	 * @var Column[]
	 */
	private $settings;

	public function __construct( array $settings = [] ) {
		array_map( [ $this, 'setSetting' ], $settings );
	}

	protected function setSetting( Column $setting ) {
		$this->offsetSet( $setting->get_name(), $setting );
	}

	public function valid() {
		return ! in_array( $this->key(), [ null, false ], true );
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

	public function offsetExists( $offset ) {
		return isset( $this->settings[ $offset ] );
	}

	public function offsetGet( $offset ) {
		return $this->settings[ $offset ];
	}

	public function offsetSet( $offset, $value ) {
		if ( ! $value instanceof Column ) {
			throw new InvalidArgumentException( "Must be a column setting." );
		}

		$this->settings[ $offset ] = $value;
	}

	public function offsetUnset( $offset ) {
		unset( $this->settings[ $offset ] );
	}

}