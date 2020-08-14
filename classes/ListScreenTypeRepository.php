<?php

namespace AC;

use AC\Entity\ListScreenType;
use AC\ListScreen\Comment;
use AC\ListScreen\Media;
use AC\ListScreen\User;

class ListScreenTypeRepository {

	/**
	 * @param array $args
	 *
	 * @return ListScreenType[]
	 */
	public function find_all( array $args = [] ) {
		$items = $this->get_items();

		$defaults = [
			'is_network' => false,
		];

		$args = array_merge( $defaults, $args );

		$items = true === $args['is_network']
			? array_filter( $items, [ $this, 'is_network' ] )
			: array_filter( $items, [ $this, 'is_non_network' ] );

		return $items;
	}

	/**
	 * @param ListScreenType $list_screen_type
	 *
	 * @return bool
	 */
	public function is_network( ListScreenType $list_screen_type ) {
		return $list_screen_type->is_network();
	}

	/**
	 * @param ListScreenType $list_screen_type
	 *
	 * @return bool
	 */
	public function is_non_network( ListScreenType $list_screen_type ) {
		return ! $this->is_network( $list_screen_type );
	}

	private function get_items() {
		$items = [];

		foreach ( $this->get_post_types() as $post_type ) {
			$items[] = new ListScreenType(
				$post_type->name,
				$post_type->labels->name,

				// todo: insert Group object
				// todo: move var to Group::Name const
				'post'
			);
		}

		if ( post_type_exists( 'attachment' ) ) {
			$items[] = new ListScreenType(
				Media::NAME,
				__( 'Media' ),
				'media'
			);
		}

		$items[] = new ListScreenType(
			User::NAME,
			__( 'Users' ),
			'user'
		);

		$items[] = new ListScreenType(
			Comment::NAME,
			__( 'Comments' ),
			'comment'
		);

		// todo: container that can sort them by Label/Group etc.
		return $items;
	}

	/**
	 * @return array
	 */
	private function get_post_type_names() {
		$post_types = get_post_types( [
			'_builtin' => false,
			'show_ui'  => true,
		] );

		foreach ( [ 'post', 'page' ] as $builtin ) {
			if ( post_type_exists( $builtin ) ) {
				$post_types[ $builtin ] = $builtin;
			}
		}

		/**
		 * Filter the post types for which Admin Columns is active
		 *
		 * @param array $post_types List of active post type names
		 *
		 * @since 2.0
		 */
		return apply_filters( 'ac/post_types', $post_types );
	}

	/**
	 * @return object[]
	 */
	private function get_post_types() {
		$post_types = [];

		foreach ( $this->get_post_type_names() as $post_type ) {
			$post_types[] = get_post_type_object( $post_type );
		}

		return $post_types;
	}

}