<?php

namespace AC\Plugin;

use AC\Capabilities;

class Updater {

	/**
	 * @var Update[]
	 */
	protected $updates;

	/**
	 * @var string
	 */
	private $current_version;

	/**
	 * @var StoredVersion
	 */
	private $stored_version;

	public function __construct( $current_version, StoredVersion $stored_version ) {
		$this->current_version = (string) $current_version;
		$this->stored_version = $stored_version;
	}

	/**
	 * @param Update $update
	 *
	 * @return $this
	 */
	public function add_update( Update $update ) {
		$this->updates[ $update->get_version() ] = $update;

		return $this;
	}

	public function parse_updates() {
		// TODO check necessary?
		if ( ! current_user_can( Capabilities::MANAGE ) ) {
			return;
		}

		if ( ! $this->stored_version->exists() ) {
			$this->stored_version->update( $this->current_version );

			return;
		}

		if ( empty( $this->updates ) ) {
			return;
		}

		// Sort by version number
		uksort( $this->updates, 'version_compare' );

		foreach ( $this->updates as $update ) {
			if ( $update->needs_update( $this->stored_version->get() ) ) {
				$update->apply_update();

				$this->stored_version->update( $update->get_version() );
			}
		}

		$this->stored_version->update( $this->current_version );
	}

}