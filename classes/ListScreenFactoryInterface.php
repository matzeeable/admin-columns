<?php

namespace AC;

use AC\Type\ListScreenData;

interface ListScreenFactoryInterface {

	/**
	 * @param ListScreenData $data
	 *
	 * @return ListScreen|null
	 */
	public function create( ListScreenData $data );

}
