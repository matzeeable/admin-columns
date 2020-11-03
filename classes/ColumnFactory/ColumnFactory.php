<?php

namespace AC\ColumnFactory;

use AC\Column;
use AC\Column\CustomField;
use AC\Column\Post;
use AC\ColumnFactoryInterface;
use AC\ListScreen;
use RuntimeException;

class ColumnFactory implements ColumnFactoryInterface {

	const COLUMN_NAME = 'name';
	const COLUMN_TYPE = 'type';

	/**
	 * @param string $list_key
	 * @param array $data
	 *
	 * @return Column|null
	 */

	// TODO: $list_key optional?
	public function create( $list_key, array $data ) {

		if ( ! isset( $data[ self::COLUMN_NAME ] ) ) {
			$data[ self::COLUMN_NAME ] = uniqid();
		}

		// TODO: validate $data. maybe turn into value object.
		if ( ! isset( $data[ self::COLUMN_TYPE ] ) ) {
			throw new RuntimeException( sprintf( 'Missing %s argument.', self::COLUMN_TYPE ) );
		}

		switch ( $list_key ) {
			case ListScreen\User::NAME :
				return $this->create_user_column( $data );
			default :
				return $this->create_post_type_column( $data );
		}
	}

	/**
	 * @param array $data
	 *
	 * @return Column|null
	 */
	protected function create_post_type_column( array $data ) {
		switch ( $data[ self::COLUMN_TYPE ] ) {

			case Post\Attachment::TYPE :
				return new Post\Attachment( $data[ self::COLUMN_NAME ], $data );
			case Post\Formats::TYPE :
				return new Post\Formats( $data[ self::COLUMN_NAME ], $data );
			case Post\PageTemplate::TYPE :
				return new Post\PageTemplate( $data[ self::COLUMN_NAME ], $data['post_type'], $data );
			case CustomField::TYPE :
				// TODO
				return new CustomField( $data[ self::COLUMN_NAME ], $data['meta_type'], $data, $data['post_type'] );
			default :
				return apply_filters( 'ac/column', $this->create_default( $data ), $data );
		}
	}

	/**
	 * @param array $data
	 *
	 * @return Column|null
	 */
	protected function create_user_column( array $data ) {
		return null;
	}

	protected function create_default( array $data ) {

		// TODO: move setters to constructor. Create Column\Default column.
		return ( new Column( $data[ self::COLUMN_TYPE ], $data[ self::COLUMN_TYPE ] ) )
			->set_original( true )
			->set_label( $data['label'] );
	}

}