<?php

namespace AC\Deprecated;

use AC\Transient;

class HookCount extends Transient {

	public function __construct() {
		parent::__construct( 'ac-deprecated-message-count' );
	}

	public function get() {
		return (int) parent::get();
	}

}