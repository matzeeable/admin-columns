<?php

namespace AC\Type;

use LogicException;

final class ListScreenKey {

	/**
	 * @var string
	 */
	private $key;

	/**
	 * @param string $key
	 */
	public function __construct( $key ) {
		if ( ! self::is_valid_key( $key ) ) {
			throw new LogicException( 'Found empty ListScreen key.' );
		}

		$this->key = $key;
	}

	/**
	 * @param string $key
	 *
	 * @return bool
	 */
	public static function is_valid_key( $key ) {
		return is_string( $key ) && $key !== '';
	}

	public function get_value() {
		return $this->key;
	}

	/**
	 * @param ListScreenKey $key
	 *
	 * @return bool
	 */
	public function equals( ListScreenKey $key ) {
		return $this->key === $key->get_key();
	}

}