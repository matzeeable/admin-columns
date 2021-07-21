<?php

namespace AC\Plugin;

class Installer {

	/**
	 * @var string
	 */
	private $current_version;

	/**
	 * @var StoredVersion
	 */
	private $stored_version;

	/**
	 * @var Install[]
	 */
	private $installers = [];

	public function __construct( $current_version, StoredVersion $stored_version ) {
		$this->current_version = (string) $current_version;
		$this->stored_version = $stored_version;
	}

	public function add_install( Install $install ) {
		$this->installers[] = $install;

		return $this;
	}

	public function install() {
		if ( ! $this->can_install() ) {
			return;
		}

		foreach ( $this->installers as $installer ) {
			$installer->install();
		}
	}

	private function is_version_equal( $version ) {
		return 0 === version_compare( $this->current_version, $version );
	}

	/**
	 * @return bool
	 */
	private function can_install() {

		// Run installer manually
		if ( '1' === filter_input( INPUT_GET, 'ac-force-install' ) ) {
			return true;
		}

		// Run installer when the current version is not equal to its stored version
		if ( ! $this->is_version_equal( $this->stored_version->get() ) ) {
			return true;
		}

		// Run installer when the current version can not be read from the plugin's header file
		if ( ! $this->current_version && ! $this->stored_version->get() ) {
			return true;
		}

		return false;
	}

}