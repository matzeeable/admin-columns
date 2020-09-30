<?php

namespace AC\Type;

final class ListScreenData {

	const PARAM_ID = 'id';
	const PARAM_KEY = 'key';
	const PARAM_COLUMNS = 'columns';
	const PARAM_SETTINGS = 'settings';

	/**
	 * @var array
	 */
	private $data;

	public function __construct( array $data ) {
		$this->data = $data;
	}

	/**
	 * @return array
	 */
	public function get_data() {
		return $this->data;
	}

	/**
	 * @param string $key
	 *
	 * @return bool
	 */
	public function has( $key ) {
		return isset( $this->data[ $key ] );
	}

	/**
	 * @param string $key
	 *
	 * @return mixed|null
	 */
	public function get( $key ) {
		if ( ! $this->has( $key ) ) {
			return null;
		}

		return $this->data[ $key ];
	}

}