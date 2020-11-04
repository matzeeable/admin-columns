<?php

namespace AC\ColumnFactory;

use AC\Column;
use AC\Column\CustomField;
use AC\Column\Post;
use AC\Column\User;
use AC\ColumnFactoryInterface;
use AC\ListScreen;
use LogicException;
use RuntimeException;

class ColumnFactory implements ColumnFactoryInterface {

	const LIST_KEY = 'list_key';
	const COLUMN_NAME = 'name';
	const COLUMN_TYPE = 'type';
	const POST_TYPE = 'post_type';
	const META_TYPE = 'meta_type';

	public function create( array $data ) {

		if ( ! isset( $data[ self::LIST_KEY ] ) ) {
			throw new LogicException( sprintf( 'Missing %s argument.', self::LIST_KEY ) );
		}

		if ( ! isset( $data[ self::COLUMN_NAME ] ) ) {
			$data[ self::COLUMN_NAME ] = uniqid();
		}

		// TODO: validate $data. maybe turn into value object.
		if ( ! isset( $data[ self::COLUMN_TYPE ] ) ) {
			throw new RuntimeException( sprintf( 'Missing %s argument.', self::COLUMN_TYPE ) );
		}

		switch ( $data[ self::LIST_KEY ] ) {
			case ListScreen\User::NAME :
				$column = $this->create_user_column( $data );
				break;
			default :
				$column = $this->create_post_type_column( $data );
		}

		return apply_filters( 'ac/column', $column, $data );
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
				return new Post\PageTemplate( $data[ self::COLUMN_NAME ], $data[ self::POST_TYPE ], $data );
			case CustomField::TYPE :
				return new CustomField( $data[ self::COLUMN_NAME ], $data[ self::META_TYPE ], $data );
			default :
				return $this->create_default( $data );
		}
	}

	/**
	 * @param array $data
	 *
	 * @return Column|null
	 */
	protected function create_user_column( array $data ) {
		switch ( $data[ self::COLUMN_TYPE ] ) {
			case User\Description::TYPE :
				return new User\Description( $data[ self::COLUMN_NAME ], $data );
			case CustomField::TYPE :
				return new CustomField( $data[ self::COLUMN_NAME ], $data[ self::META_TYPE ], $data );
			default :
				return $this->create_default( $data );
		}
	}

	protected function create_default( array $data ) {

		// TODO: move setters to constructor. Create Column\Default column.
		return ( new Column( $data[ self::COLUMN_TYPE ], $data[ self::COLUMN_TYPE ] ) )
			->set_original( true )
			->set_label( $data['label'] );
	}

}