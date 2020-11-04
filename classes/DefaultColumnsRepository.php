<?php

namespace AC;

class DefaultColumnsRepository {

	const OPTIONS_KEY = 'cpac_options_';

	/**
	 * @param string $list_key
	 * @param string $column_name
	 *
	 * @return array|null
	 */
	public function find( $list_key, $column_name ) {
		$columns = $this->find_all( $list_key );

		return isset( $columns[ $column_name ] )
			? $columns[ $column_name ]
			: null;
	}

	/**
	 * @param string $list_key
	 *
	 * @return array
	 */
	public function find_all( $list_key ) {
		return $this->get( $list_key );
	}

	/**
	 * @param string $list_key
	 *
	 * @return string
	 */
	private function get_option_name( $list_key ) {
		return self::OPTIONS_KEY . $list_key . "__default";
	}

	/**
	 * @param string $list_key
	 * @param array $columns
	 *
	 * @return void
	 */
	public function update( $list_key, array $columns ) {
		unset( $columns['cb'] );

		update_option( $this->get_option_name( $list_key ), $columns, false );
	}

	/**
	 * @param string $list_key
	 *
	 * @return bool
	 */
	public function exists( $list_key ) {
		return false !== get_option( $this->get_option_name( $list_key ) );
	}

	/**
	 * @param string $list_key
	 *
	 * @return array
	 */
	private function get( $list_key ) {
		return get_option( $this->get_option_name( $list_key ), [] );
	}

	/**
	 * @param string $list_key
	 *
	 * @return void
	 */
	public function delete( $list_key ) {
		delete_option( $this->get_option_name( $list_key ) );
	}

}