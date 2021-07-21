<?php

namespace AC\Plugin\StoredVersion;

use AC\Plugin\StoredVersion;

class Site implements StoredVersion {

	/**
	 * @var string
	 */
	private $version_key;

	public function __construct( $version_key ) {
		$this->version_key = $version_key;
	}

	public function update( $version ) {
		return update_option( $this->version_key, $version, false );
	}

	public function get() {
		return (string) get_option( $this->version_key );
	}

	public function exists() {
		global $wpdb;

		if ( $this->get() ) {
			return true;
		}

		// Before version 3.0.5
		$results = $wpdb->get_results( "SELECT option_id FROM $wpdb->options WHERE option_name LIKE 'cpac_options_%' LIMIT 1" );

		if ( empty( $results ) ) {
			return false;
		}

		return true;
	}

	// TODO remove
	//	protected function update_stored_version( $version ) {
	//		return update_option( $this->version_key, $version, false );
	//	}
	//
	//	protected function get_stored_version() {
	//		return (string) get_option( $this->version_key );
	//	}
	//
	//	protected function is_new_install() {
	//		global $wpdb;
	//
	//		if ( $this->get_stored_version() ) {
	//			return false;
	//		}
	//
	//		// Before version 3.0.5
	//		$results = $wpdb->get_results( "SELECT option_id FROM $wpdb->options WHERE option_name LIKE 'cpac_options_%' LIMIT 1" );
	//
	//		return empty( $results );
	//	}

}