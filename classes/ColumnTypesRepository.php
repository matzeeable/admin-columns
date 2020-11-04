<?php

namespace AC;

use AC\Column\CustomField;
use AC\Column\Post;
use AC\Column\User;
use AC\Entity\ColumnType;
use InvalidArgumentException;

class ColumnTypesRepository {

	const LIST_KEY = 'list_key';
	const GROUP = 'group';

	/**
	 * @param array $args
	 *
	 * @return ColumnType[]
	 */

	// TODO: return ColumnTypeCollection
	public function find_all( array $args = [] ) {
		if ( ! isset( $args[ self::LIST_KEY ] ) ) {
			throw new InvalidArgumentException( sprintf( 'Missing %s argument.', self::LIST_KEY ) );
		}

		switch ( $args[ self::LIST_KEY ] ) {
			case ListScreen\User::NAME :
				$columns = $this->get_user_columns();
				break;

			default :
				$columns = $this->get_post_columns( $args[ self::LIST_KEY ] );
		}

		// TODO: filter by group

		// TODO: add hook
		return $columns;
	}

	protected function get_post_columns( $list_key ) {

		// TODO: add column types
		$columns = [
			new ColumnType( Post\Attachment::TYPE, __( 'Attachments', 'codepress-admin-columns' ), $list_key ),
			new ColumnType( CustomField::TYPE, __( 'Custom Field', 'codepress-admin-columns' ), $list_key ),
		];

		if ( post_type_supports( $list_key, 'post-formats' ) ) {
			$columns[] = new ColumnType( Post\Formats::TYPE, __( 'Post Format', 'codepress-admin-columns' ), $list_key );
		}
		if ( get_page_templates( null, $list_key ) ) {
			$columns[] = new ColumnType( Post\PageTemplate::TYPE, __( 'Page Template', 'codepress-admin-columns' ), $list_key );
		}

		return $columns;
	}

	protected function get_user_columns() {
		return [
			new ColumnType( User\FirstName::TYPE, __( 'First Name', 'codepress-admin-columns' ), ListScreen\User::NAME ),
			new ColumnType( User\Description::TYPE, __( 'Description', 'codepress-admin-columns' ), ListScreen\User::NAME ),
		];
	}

	/**
	 * @param string $key
	 * @param string $list_key
	 *
	 * @return ColumnType|null
	 */
	public function find( $key, $list_key ) {
		$columns = $this->find_all( [
			self::LIST_KEY => $list_key
		] );

		foreach ( $columns as $column ) {
			if ( $column->get_key() === $key ) {
				return $column;
			}
		}

		return null;
	}

}