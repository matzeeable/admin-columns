<?php

namespace AC\Column;

interface Renderable {

	/**
	 * @param int $id
	 *
	 * @return string|null
	 */
	public function render( $id );

}