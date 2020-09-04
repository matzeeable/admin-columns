<?php

namespace AC\ListScreen;

use AC;
use AC\ListScreen;
use AC\MetaType;
use AC\Type\ListScreenId;
use AC\Type\ListScreenKey;
use AC\Type\TableId;
use ReflectionException;
use WP_Comment;
use WP_Comments_List_Table;

/**
 * @since 2.0
 */
class Comment extends ListScreen {

	const NAME = 'wp-comments';

	public function __construct( ListScreenId $id = null ) {
		parent::__construct(
			new ListScreenKey( self::NAME ),
			new MetaType( MetaType::COMMENT ),
			new TableId( 'edit', 'edit-comments' ),
			__( 'Comments' ),
			$id
		);
	}

	/**
	 * @param int $id
	 *
	 * @return WP_Comment
	 */
	protected function get_object( $id ) {
		return get_comment( $id );
	}

	public function register() {
		add_action( 'manage_comments_custom_column', function ( $column_name, $id ) {
			echo $this->get_display_value_by_column_name( $column_name, $id );
		}, 100, 2 );
	}

	public function get_table_attr_id() {
		return '#the-comment-list';
	}

	/**
	 * Register column types
	 * @throws ReflectionException
	 */
	protected function register_column_types() {
		$this->register_column_type( new AC\Column\CustomField );
		$this->register_column_type( new AC\Column\Actions );
		$this->register_column_types_from_dir( 'AC\Column\Comment' );
	}

	public function get_url() {
		return admin_url( 'comments.php' );
	}

	/**
	 * @return WP_Comments_List_Table
	 * @deprecated NEWVERSION
	 */
	public function get_list_table() {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return ( new AC\ListTableFactory() )->create_comment_table( $this->table_id->get_screen_id() );
	}

}