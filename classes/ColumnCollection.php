<?php

namespace AC;

class ColumnCollection extends Collection {

	public function add( Column $column ) {
		$this->put( $column->get_name(), $column );
	}

	/**
	 * @param string $column_name
	 * @param null $default
	 *
	 * @return Column|null
	 */
	public function get( $column_name, $default = null ) {
		return parent::get( $column_name, $default );
	}

}