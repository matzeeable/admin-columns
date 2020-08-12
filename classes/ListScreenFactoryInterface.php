<?php

namespace AC;

use AC\Type\ListScreenId;

interface ListScreenFactoryInterface {

	/**
	 * @param string $key
	 * @param ListScreenId $id
	 *
	 * @return ListScreen|null
	 */
	public function create( $key, ListScreenId $id );

}
