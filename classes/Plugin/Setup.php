<?php

namespace AC\Plugin;

use AC;
use AC\Registrable;

class Setup implements Registrable {

	/**
	 * @var Installer
	 */
	private $installer;

	/**
	 * @var Updater
	 */
	private $updater;

	public function __construct( Installer $installer, Updater $updater ) {
		$this->installer = $installer;
		$this->updater = $updater;
	}

	public function register() {
		add_action( 'init', [ $this, 'run' ], 1000 );
	}

	public function run() {
		$this->installer->install();
		$this->updater->parse_updates();
	}

}