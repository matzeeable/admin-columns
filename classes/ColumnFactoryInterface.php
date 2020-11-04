<?php

namespace AC;

interface ColumnFactoryInterface {

	/**
	 * @param array $data
	 *
	 * @return Column|null
	 */
	public function create( array $data );

}