<?php

namespace AC\Plugin;

abstract class Update {

	/**
	 * @var string Assumes this regex for versions: ^[1-9]\.[0-9]\.[1-9][0-9]?$
	 */
	protected $version;

	public function __construct( $version ) {
		$this->version = (string) $version;

		// TODO validate?
	}

	/**
	 * Check if this update needs to be applied
	 * @return bool
	 */
	public function needs_update( $stored_version ) {
		return version_compare( $this->version, $stored_version, '>' );
	}

	/**
	 * @return void
	 */
	abstract public function apply_update();

	/**
	 * @return string
	 */
	public function get_version() {
		return $this->version;
	}

}