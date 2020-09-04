<?php

namespace AC;

use WP_Screen;

interface ListScreenFactoryInterface {

	/**
	 * @param string $key
	 *
	 * @return ListScreen|null
	 */
	public function create( $key );

	/**
	 * @param WP_Screen $wp_screen
	 *
	 * @return ListScreen|null
	 */
	public function create_by_screen( WP_Screen $wp_screen );

}
