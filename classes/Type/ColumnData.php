<?php

namespace AC\Type;

use ArrayObject;

final class ColumnData extends ArrayObject {

	public function get( $index ) {
		return $this->offsetExists( $index )
			? $this->offsetGet( $index )
			: null;
	}

	public function exists( $index ) {
		return $this->offsetExists( $index );
	}

}