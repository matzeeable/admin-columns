<?php

namespace AC\Type;

final class ListScreenData {

	const PARAM_ID = 'id';
	const PARAM_KEY = 'key';
	const PARAM_COLUMNS = 'columns';
	const PARAM_SETTINGS = 'settings';
	const PARAM_DATE = 'date';

	// TODO: is this a setting?
	const PARAM_TITLE = 'title';

	// TODO: required?
	const PARAM_META_TYPE = 'meta_type';
	const PARAM_POST_TYPE = 'post_type';
	const PARAM_TAXONOMY = 'taxonomy';

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