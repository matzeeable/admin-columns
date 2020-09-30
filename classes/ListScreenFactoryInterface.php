<?php

namespace AC;

use AC\Type\ListScreenData;
use WP_Screen;

interface ListScreenFactoryInterface {

	/**
	 * @param ListScreenData $data
	 *
	 * @return ListScreen|null
	 */
	public function create( ListScreenData $data );

	/**
	 * @param WP_Screen $wp_screen
	 *
	 * @return ListScreen|null
	 */
	public function create_by_screen( WP_Screen $wp_screen );

}
