<?php

namespace AC\Column\Post;

use AC\Column;
use AC\Settings\ColumnSettingsCollection;

class Formats extends Column {

	const TYPE = 'column-post_formats';

	public function __construct( $name, ColumnSettingsCollection $settings ) {
		parent::__construct( self::TYPE, $name, $settings );
	}

	public function get_raw_value( $post_id ) {
		return get_post_format( $post_id );
	}

	public function get_taxonomy() {
		return 'post_format';
	}

}