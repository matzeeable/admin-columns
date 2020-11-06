<?php

namespace AC\ColumnFactory;

use AC\Column;
use AC\Column\CustomField;
use AC\Column\Post;
use AC\Column\User;
use AC\ColumnFactoryInterface;
use AC\ListScreen;
use InvalidArgumentException;

class ColumnFactory implements ColumnFactoryInterface {

	const LIST_KEY = 'list_key';
	const NAME = 'name';
	const TYPE = 'type';
	const LABEL = 'label';
	const POST_TYPE = 'post_type';
	const META_TYPE = 'meta_type';

	public function create( array $data ) {

		// TODO: validate $data. maybe turn into value object.
		if ( ! isset( $data[ self::LIST_KEY ] ) ) {
			throw new InvalidArgumentException( sprintf( 'Missing %s argument.', self::LIST_KEY ) );
		}

		if ( ! isset( $data[ self::TYPE ] ) ) {
			throw new InvalidArgumentException( sprintf( 'Missing %s argument.', self::TYPE ) );
		}

		if ( ! isset( $data[ self::NAME ] ) ) {
			$data[ self::NAME ] = uniqid();
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
		switch ( $data[ self::TYPE ] ) {
			case Post\Attachment::TYPE :
				return new Post\Attachment( $data[ self::NAME ], $data );
			case Post\Formats::TYPE :
				return new Post\Formats( $data[ self::NAME ], $data );
			case Post\PageTemplate::TYPE :
				return new Post\PageTemplate( $data[ self::NAME ], $data[ self::POST_TYPE ], $data );
			case CustomField::TYPE :
				return new CustomField( $data[ self::NAME ], $data[ self::META_TYPE ], $data );
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
		switch ( $data[ self::TYPE ] ) {
			case User\Description::TYPE :
				return new User\Description( $data[ self::NAME ], $data );
			case CustomField::TYPE :
				return new CustomField( $data[ self::NAME ], $data[ self::META_TYPE ], $data );
			default :
				return $this->create_default( $data );
		}
	}

	protected function create_default( array $data ) {
		return ( new Column( $data[ self::TYPE ], $data[ self::TYPE ], $data[ self::LABEL ], $data ) );
	}

}