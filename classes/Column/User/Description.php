<?php

namespace AC\Column\User;

use AC\Column;
use AC\MetaType;
use AC\Settings;

class Description extends Column\Meta {

	const TYPE = 'column-user_description';

	public function __construct( $name, array $data = [] ) {
		parent::__construct( self::TYPE, $name, new MetaType( MetaType::USER ), $data );
	}

	// TODO: remove?
	public function get_meta_key() {
		return 'description';
	}

	public function get_raw_value( $user_id ) {
		return get_the_author_meta( 'user_description', $user_id );
	}

	public function register_settings() {
		$this->add_setting( new Settings\Column\WordLimit( $this ) );
		$this->add_setting( new Settings\Column\BeforeAfter( $this ) );
	}

}