<?php

namespace AC\Settings\Column;

use AC\Collection;
use AC\Settings;

class Images extends Settings\Column\Image {

	const NAME = 'images';

	// TODO: image_limit
	public function __construct() {
		parent::__construct( self::NAME );
	}

	protected function set_name() {
		return $this->name = 'images';
	}

	public function get_dependent_settings() {
		return [ new Settings\Column\NumberOfItems() ];
	}

	private function get_image_limit() {
		return 10;

		// TODO
//		$this->column->get_setting( 'number_of_items' )->get_value();
	}

	public function format( $value, $original_value ) {
		$collection = new Collection( (array) $value );
		$removed = $collection->limit( $this->get_image_limit() );

		return ac_helper()->html->images( parent::format( $collection->all(), $original_value ), $removed );
	}

}