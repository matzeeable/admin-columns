<?php

namespace AC\ListScreenFactory;

use AC\ListScreen;
use AC\ListScreenFactoryInterface;
use AC\Type\ListScreenId;
use WP_Screen;

class ListScreenFactory implements ListScreenFactoryInterface {

	/**
	 * @var string
	 */
	protected $default_list_screen = ListScreen\Post::CLASS;

	/**
	 * @var array
	 */
	protected $list_screens = [
		ListScreen\User::NAME    => ListScreen\User::CLASS,
		ListScreen\Media::NAME   => ListScreen\Media::CLASS,
		ListScreen\Comment::NAME => ListScreen\Comment::CLASS,
	];

	public function create( $key, ListScreenId $id ) {
		if ( isset( $this->list_screens[ $key ] ) ) {
			$list_screen = new $this->list_screens[$key]();
		} else {
			$list_screen = new $this->default_list_screen( $key );
		}

		return $id
			? $list_screen->set_layout_id( $id->get_id() )
			: $list_screen;
	}

	public function create_by_screen( WP_Screen $wp_screen, ListScreenId $id ) {
		switch ( $wp_screen->base ) {
			case 'edit' :
				return $wp_screen->post_type
					? $this->create( $wp_screen->post_type, $id )
					: null;
			case 'users' :
				return 'users' === $wp_screen->id
					? $this->create( ListScreen\User::NAME, $id )
					: null;
			case 'upload' :
				return 'upload' === $wp_screen->id
					? $this->create( ListScreen\Media::NAME, $id )
					: null;
			case 'edit-comments' :
				return 'edit-comments' === $wp_screen->id
					? $this->create( ListScreen\Media::NAME, $id )
					: null;
			default :
				return null;

		}
	}

}