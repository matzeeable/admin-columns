<?php

namespace AC;

class DefaultColumnsRepository {

	const OPTIONS_KEY = 'cpac_options_';

	/**
	 * @param ListScreen $list_screen
	 * @param string $column_name
	 *
	 * @return Column|null
	 */
	public function find( ListScreen $list_screen, $column_name ) {
		$columns = $this->find_all( $list_screen );

		return isset( $columns[ $column_name ] )
			? $columns[ $column_name ]
			: null;
	}

	/**
	 * @param string $list_screen
	 *
	 * @return Column[]
	 */
	public function find_all( ListScreen $list_screen ) {
		$columns = [];

		foreach ( $this->get( $list_screen->get_key() ) as $name => $label ) {
			if ( 'cb' === $name ) {
				continue;
			}

			$columns[ $name ] = ( new Column() )
				->set_original( true )
				->set_name( $name )
				->set_type( $name )
				->set_label( $label )
				->set_list_screen( $list_screen );
		}

		return $columns;
	}

	/**
	 * @param string $list_screen_key
	 *
	 * @return string
	 */
	private function get_option_name( $list_screen_key ) {
		return self::OPTIONS_KEY . $list_screen_key . "__default";
	}

	/**
	 * @param $list_screen_key
	 * @param array $columns
	 *
	 * @return void
	 */
	public function update( $list_screen_key, array $columns ) {
		update_option( $this->get_option_name( $list_screen_key ), $columns, false );
	}

	/**
	 * @param $list_screen_key
	 *
	 * @return bool
	 */
	public function exists( $list_screen_key ) {
		return false !== get_option( $this->get_option_name( $list_screen_key ) );
	}

	/**
	 * @param $list_screen_key
	 *
	 * @return array
	 */
	private function get( $list_screen_key ) {
		return get_option( $this->get_option_name( $list_screen_key ), [] );
	}

	/**
	 * @param $list_screen_key
	 *
	 * @return void
	 */
	public function delete( $list_screen_key ) {
		delete_option( $this->get_option_name( $list_screen_key ) );
	}

}