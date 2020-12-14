<?php

namespace AC\Column\Post;

use AC\Column;
use AC\Settings\ColumnSettingsCollection;

class ID extends Column implements Column\Renderable {

	const TYPE = 'column-postid';

	public function __construct( $id, ColumnSettingsCollection $settings ) {
		parent::__construct( self::TYPE, $id, $settings );
	}

	public function render( $id ) {
		return $id;
	}

}