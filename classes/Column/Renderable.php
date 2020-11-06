<?php

namespace AC\Column;

interface Renderable {

	/**
	 * @param int $id
	 *
	 * @return string
	 */
	public function render( $id );

	// TODO: trait? Remove?
	public function get_empty_char();

	public function get_separator();

}