<?php

namespace AC;

class ColumnFactory implements ColumnFactoryInterface, Registrable {

	/**
	 * @var ColumnFactoryInterface[]
	 */
	private $factories;

	public function set_factories( array $factories ) {
		array_map( [ $this, 'add_factory' ], $factories );
	}

	public function add_factory( ColumnFactoryInterface $factory ) {
		$this->factories[] = $factory;
	}

	public function create( array $data ) {
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
		do_action( 'ac/column_factory', $this );
	}

}