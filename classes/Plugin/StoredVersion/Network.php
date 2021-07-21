<?php

namespace AC\Plugin\StoredVersion;

use AC\Plugin\StoredVersion;

class Network implements StoredVersion {

	/**
	 * @var string
	 */
	private $version_key;

	public function __construct( $version_key ) {
		$this->version_key = $version_key;
	}

	public function update( $version ) {
		return update_site_option( $this->version_key, $version );
	}

	public function get() {
		return (string) get_site_option( $this->version_key );
	}

	public function exists() {
		return $this->get() || get_site_option( 'cpupdate_cac-pro' );
	}

	// TODO remove
	//	protected function update_stored_version( $version ) {
	//		return update_site_option( $this->version_key, $version );
	//	}
	//
	//	protected function get_stored_version() {
	//		return (string) get_site_option( $this->version_key );
	//	}
	//
	//	protected function is_new_install() {
	//		// Current and before version 5 check
	//		return empty( $this->get_stored_version() ) && empty( get_site_option( 'cpupdate_cac-pro' ) );
	//	}

}