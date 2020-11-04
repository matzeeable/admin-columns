<?php

namespace AC;

use AC\Type\ListScreenData;

class ListScreenFactory implements ListScreenFactoryInterface, Registrable {

	/**
	 * @var ListScreenFactoryInterface[]
	 */
	private $factories;

	public function set_factories( array $factories ) {
		array_map( [ $this, 'add_factory' ], $factories );
	}

	public function add_factory( ListScreenFactoryInterface $factory ) {
		$this->factories[] = $factory;
	}

	public function create( ListScreenData $data ) {
		foreach ( array_reverse( $this->factories ) as $factory ) {
			$list_screen = $factory->create( $data );

			if ( ! $list_screen ) {
				continue;
			}

			return $list_screen;
		}

		return null;
	}

	public function register() {
		do_action( 'ac/list_screen_factory', $this );
	}

}