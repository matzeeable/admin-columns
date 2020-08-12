<?php

namespace AC\ListScreenFactory;

use AC\ListScreen;
use AC\ListScreenFactoryInterface;
use AC\Type\ListScreenId;

class ListScreenFactory implements ListScreenFactoryInterface {

	/**
	 * @param string $key
	 *
	 * @return ListScreen
	 */
	public function create( $key, ListScreenId $id ) {
		switch ( $key ) {
			case 'wp-users' :
				return ( new ListScreen\User() )->set_layout_id( $id->get_id() );
			case 'wp-media' :
				return ( new ListScreen\Media() )->set_layout_id( $id->get_id() );
			case 'wp-comments' :
				return ( new ListScreen\Comment() )->set_layout_id( $id->get_id() );
			default :
				return ( new ListScreen\Post( $key ) )->set_layout_id( $id->get_id() );
		}
	}
}