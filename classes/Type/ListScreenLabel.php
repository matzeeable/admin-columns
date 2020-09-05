<?php

namespace AC\Type;

use InvalidArgumentException;

class ListScreenLabel {

	/**
	 * @var string
	 */
	private $single;

	/**
	 * @var string
	 */
	private $plural;

	public function __construct( $single, $plural ) {
		if ( ! $this->validate( $single ) || ! $this->validate( $plural ) ) {
			throw new InvalidArgumentException( 'Invalid label argument.' );
		}

		$this->single = $single;
		$this->plural = $plural;
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
	public function get_single() {
		return $this->single;
	}

	/**
	 * @return string
	 */
	public function get_plural() {
		return $this->plural;
	}

	public function __toString() {
		return $this->plural;
	}

}