<?php

namespace AC;

use AC\Type\ListScreenId;
use WP_Screen;

interface ListScreenFactoryInterface {

	/**
	 * @param string       $key
	 * @param ListScreenId $id
	 *
	 * @return ListScreen|null
	 */
	public function create( $key, ListScreenId $id );

	/**
	 * @param WP_Screen $wp_screen
	 *
	 * @return ListScreen|null
	 */
	public function create_by_screen( WP_Screen $wp_screen, ListScreenId $id );

}
