<?php

namespace AC\Plugin\Setup;

use AC;
use AC\Plugin\Install;
use AC\Plugin\Installer;
use AC\Plugin\StoredVersion;
use AC\Plugin\Update;
use AC\Plugin\Updater;

class Site extends AC\Plugin\Setup {

	public function __construct( $current_version, StoredVersion $stored_version ) {
		parent::__construct(
			$this->get_installer( $current_version, $stored_version ),
			$this->get_updater( $current_version, $stored_version )
		);
	}

	private function get_installer( $current_version, StoredVersion $stored_version ) {
		$installer = new Installer( $current_version, $stored_version );

		$installer->add_install( new Install\Capabilities() )
		          ->add_install( new Install\CreateDatabase() );

		return $installer;
	}

	private function get_updater( $current_version, StoredVersion $stored_version ) {
		$updater = new Updater( $current_version, $stored_version );

		// TODO auto load objects from folder
		$updater->add_update( new Update\V3005() )
		        ->add_update( new Update\V3007() )
		        ->add_update( new Update\V3201() )
		        ->add_update( new Update\V4000() );

		return $updater;
	}
}