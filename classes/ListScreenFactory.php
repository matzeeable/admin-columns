<?php

namespace AC;

use AC\ListScreen\Post;
use AC\Type\ColumnId;
use AC\Type\ListScreenId;
use AC\Type\ListScreenType;
use RuntimeException;

class ListScreenFactory {

	public function create( ListScreenType $type, array $args = [] ) {

		switch ( $type->get_value() ) {

			case Post::TYPE :
				$post_type = get_post_type_object( $args['subtype'] );

				if ( ! $post_type ) {
					throw new RuntimeException( 'Invalid post type.' );
				}

				$id = isset( $args['id'] ) && ListScreenId::is_valid_id( $args['id'] )
					? new ListScreenId( $args['id'] )
					: null;

				$columns = isset( $args['columns'] )
					? $this->get_columns( new ColumnFactory\Post(), $args['columns'] )
					: new ColumnCollection();

				$settings = isset( $args['settings'] )
					? $args['settings']
					: [];

				return new Post( $args['subtype'], $post_type->labels->singular_name, $columns, $settings, $id );
		}

		return null;
	}

	public function create_by_key( $key, array $args = [] ) {
		$type = Post::TYPE;

		$args['subtype'] = $key;

		// todo: ms-users, taxonomy etc.

		return $this->create( new ListScreenType( $type ), $args );
	}

	/**
	 * @param ColumnFactory $factory
	 * @param array         $columns_data
	 *
	 * @return ColumnCollection
	 */
	protected function get_columns( ColumnFactory $factory, array $columns_data = [] ) {
		$columns = new ColumnCollection();

		foreach ( $columns_data as $id => $column_data ) {
			$type = $column_data['type'];

			unset( $column_data['type'] );

			$column = $factory->create( $type, new ColumnId( $id ), $column_data );

			if ( ! $column ) {
				continue;
			}

			$columns->add( $column );
		}

		return $columns;
	}

}