<?php

namespace AC;

class ColumnFactory implements ColumnFactoryInterface {

	/**
	 * @var ColumnFactoryInterface[]
	 */
	private $factories;

	/**
	 * @param ColumnFactoryInterface $factory
	 */
	public function add_factory( ColumnFactoryInterface $factory ) {
		$this->factories[] = $factory;
	}

	public function create( $list_key, array $data ) {
		foreach ( array_reverse( $this->factories ) as $factory ) {
			$list_screen = $factory->create( $list_key, $data );

			if ( ! $list_screen ) {
				continue;
			}

			return $list_screen;
		}

		return null;
	}

}