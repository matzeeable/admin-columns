<?php

namespace AC;

interface ColumnFactoryInterface {

	/**
	 * @param string $list_key
	 * @param array $data
	 *
	 * @return Column|null
	 */
	public function create( $list_key, array $data );

}
