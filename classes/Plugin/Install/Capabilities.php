<?php

namespace AC\Plugin\Install;

use AC;
use AC\Plugin\Install;

class Capabilities implements Install {

	public function install() {
		global $wp_roles;

		if ( ! $wp_roles ) {
			$wp_roles = new \WP_Roles();
		}

		do_action( 'ac/capabilities/init', $wp_roles );
	}

}