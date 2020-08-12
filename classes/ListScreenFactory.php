<?php

namespace AC;

use AC\Type\ListScreenId;
use LogicException;

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

	public function create( $key, ListScreenId $id ) {
		foreach ( array_reverse( $this->factories ) as $factory ) {
			$list_screen = $factory->create( $key, $id );

			if ( ! $list_screen ) {
				continue;
			}

			return $list_screen;
		}

		return new LogicException( 'Unsuported List Screen.' );
	}

}
