<?php

namespace AC\Type;

use InvalidArgumentException;

class Screen {

	/**
	 * @var string
	 */
	private $base;

	/**
	 * @var string
	 */
	private $id;

	/**
	 * @var string
	 */
	private $key;

	/**
	 * @var string
	 */
	private $extra;

	public function __construct( $base, $id, $key, $extra = null ) {
		if ( ! $this->validate( $base ) ) {
			throw new InvalidArgumentException( 'Invalid screen base argument.' );
		}

		if ( ! $this->validate( $id ) ) {
			throw new InvalidArgumentException( 'Invalid screen id argument.' );
		}

		if ( ! $this->validate( $key ) ) {
			throw new InvalidArgumentException( 'Invalid screen key argument.' );
		}

		$this->base = $base;
		$this->id = $id;
		$this->key = $key;
		$this->extra = $extra;
	}

	/**
	 * @param string $var
	 *
	 * @return bool
	 */
	private function validate( $var ) {
		return is_string( $var ) && $var;
	}

	/**
	 * @return string
	 */
	public function get_base() {
		return $this->base;
	}

	/**
	 * @return string
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function get_key() {
		return $this->key;
	}

	/**
	 * @return string
	 */
	public function get_extra() {
		return $this->extra;
	}

}