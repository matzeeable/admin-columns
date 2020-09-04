<?php

namespace AC;

use WP_Screen;

class ListScreenFactory implements ListScreenFactoryInterface {

	/**
	 * @var ListScreenFactoryInterface[]
	 */
	private $factories;

	/**
	 * @param ListScreenFactoryInterface $factory
	 */
	public function add_factory( ListScreenFactoryInterface $factory ) {
		$this->factories[] = $factory;
	}

	public function create( $key ) {
		foreach ( array_reverse( $this->factories ) as $factory ) {
			$list_screen = $factory->create( $key );

			if ( ! $list_screen ) {
				continue;
			}

			return $list_screen;
		}

		return null;
	}

	public function create_by_screen( WP_Screen $wp_screen ) {
		foreach ( array_reverse( $this->factories ) as $factory ) {
			$list_screen = $factory->create_by_screen( $wp_screen );

			if ( ! $list_screen ) {
				continue;
			}

			return $list_screen;
		}

		return null;
	}

}
