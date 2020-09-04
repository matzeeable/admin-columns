<?php

namespace AC\ListScreenFactory;

use AC\ListScreen;
use AC\ListScreenFactoryInterface;
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

	public function create( $key ) {
		if ( isset( $this->list_screens[ $key ] ) ) {
			return new $this->list_screens[$key]();
		}

		return new $this->default_list_screen( $key );
	}

	public function create_by_screen( WP_Screen $wp_screen ) {
		switch ( $wp_screen->base ) {
			case 'edit' :
				return $wp_screen->post_type
					? $this->create( $wp_screen->post_type )
					: null;
			case 'users' :
				return 'users' === $wp_screen->id
					? $this->create( ListScreen\User::NAME )
					: null;
			case 'upload' :
				return 'upload' === $wp_screen->id
					? $this->create( ListScreen\Media::NAME )
					: null;
			case 'edit-comments' :
				return 'edit-comments' === $wp_screen->id
					? $this->create( ListScreen\Media::NAME )
					: null;
			default :
				return null;

		}
	}

}