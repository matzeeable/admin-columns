<?php

namespace AC\Settings\Column;

use AC\Collection;
use AC\Settings;

class Images extends Settings\Column\Image {

	const NAME = 'images';
	const OPTION_LIMIT = 'number_of_items';

	/**
	 * @var int
	 */
	private $limit;


	// TODO: image_limit
	public function __construct( $limit = null ) {
		parent::__construct( self::NAME );

		if ( null === $limit ) {
			$limit = 10;
		}

		$this->limit = $limit;
	}

	public function get_dependent_settings() {
		// TODO inject in constructor
		return [ new Settings\Column\NumberOfItems() ];
	}

	private function get_image_limit() {
		return $this->limit;
	}

	public function format( $value, $original_value ) {
		$collection = new Collection( (array) $value );
		$removed = $collection->limit( $this->get_image_limit() );

		return ac_helper()->html->images( parent::format( $collection->all(), $original_value ), $removed );
	}

}