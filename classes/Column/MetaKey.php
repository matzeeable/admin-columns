<?php

namespace AC\Column;

use AC;

// TODO: rename to Meta
interface MetaKey {

	/**
	 * @return string
	 */
	public function get_meta_key();

	/**
	 * @param int $id
	 *
	 * @return mixed
	 */
	public function get_meta_value( $id );

}