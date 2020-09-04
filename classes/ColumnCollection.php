<?php

namespace AC;

// TODO: implement
class ColumnCollection extends Collection {

	public function add( Column $column ) {
		$this->put( $column->get_name(), $column );
	}

}