<?php

namespace AC;

use AC\Type\ColumnData;

interface ColumnFactoryInterface {

	/**
	 * @param ColumnData $data
	 *
	 * @return Column|null
	 */
	public function create( ColumnData $data );

}