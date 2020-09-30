<?php

namespace AC;

use AC\Entity\ListScreenType;
use AC\ListScreen\Comment;
use AC\ListScreen\Media;
use AC\ListScreen\User;
use LogicException;

class ListScreenTypeRepository {

	/**
	 * @param array $args
	 *
	 * @return ListScreenType[]
	 */
	public function find_all( array $args = [] ) {
		if ( ! did_action( 'init' ) ) {
			throw new LogicException( 'Called before init action.' );
		}

		$items = $this->get_items();

		if ( isset( $args['is_network'] ) ) {
			$items = true === $args['is_network']
				? array_filter( $items, [ $this, 'is_network' ] )
				: array_filter( $items, [ $this, 'is_non_network' ] );
		}

		return $items;
	}

	/**
	 * @param string $key
	 *
	 * @return ListScreenType|null
	 */
	public function find( $key ) {
		foreach ( $this->get_items() as $item ) {
			if ( $key === $item->get_key() ) {
				return $item;
			}
		}

		return null;
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

	/**
	 * @return ListScreenType[]
	 */
	private function get_items() {
		$items = [];

		foreach ( $this->get_post_types() as $post_type ) {
			$items[] = new ListScreenType(
				$post_type->name,
				$post_type->labels->name,
				ListScreenGroups::POST_TYPE,
				add_query_arg( [ 'post_type' => $post_type ], admin_url( 'edit.php' ) )
			);
		}

		if ( post_type_exists( 'attachment' ) ) {
			$items[] = new ListScreenType(
				Media::NAME,
				__( 'Media' ),
				ListScreenGroups::MEDIA,
				add_query_arg( [ 'mode' => 'list' ], admin_url( 'upload.php' ) ),
			);
		}

		$items[] = new ListScreenType(
			User::NAME,
			__( 'Users' ),
			ListScreenGroups::USER,
			admin_url( 'users.php' ),
		);

		$items[] = new ListScreenType(
			Comment::NAME,
			__( 'Comments' ),
			ListScreenGroups::COMMENT,
			admin_url( 'comments.php' )
		);

		// todo: container that can sort them by Label/Group etc.
		return apply_filters( 'ac/list_screen_types', $items );
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