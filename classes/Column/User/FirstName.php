<?php

namespace AC\Column\User;

use AC\Column;

/**
 * @since 2.0
 */
class FirstName extends Column\Meta {

	const TYPE = 'column-first_name';

	public function __construct() {
		$this->set_type( self::TYPE )
		     ->set_label( __( 'First Name', 'codepress-admin-columns' ) );
	}

	public function get_meta_key() {
		return 'first_name';
	}

	public function get_value( $user_id ) {
		$value = $this->get_raw_value( $user_id );

		return $value ?: $this->get_empty_char();
	}

	public function get_raw_value( $user_id ) {
		return get_user_meta( $user_id, $this->get_meta_key(), true );
	}

}