<?php

namespace AC;

use AC\Type\ListScreenData;

interface ListScreenRepositoryWritable extends ListScreenRepository {

	/**
	 * @param ListScreenData $list_screen_data
	 *
	 * @return void
	 */
	public function save( ListScreenData $list_screen_data );

	/**
	 * @param ListScreen $list_screen
	 *
	 * @return void
	 */
	public function delete( ListScreen $list_screen );

}