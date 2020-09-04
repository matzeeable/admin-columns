<?php

namespace AC\ListScreen;

use AC;
use AC\ListScreen;
use ReflectionException;
use WP_Comment;
use WP_Comments_List_Table;

/**
 * @since 2.0
 */
class Comment extends ListScreen {

	const NAME = 'wp-comments';

	public function __construct() {

		$this->set_label( __( 'Comments' ) )
		     ->set_singular_label( __( 'Comment' ) )
		     ->set_key( self::NAME )
		     ->set_group( 'comment' );

		$this->meta_type = new AC\MetaType( AC\MetaType::COMMENT );
		$this->heading_hook = 'manage_edit-comments_columns';
	}

	/**
	 * @param int $id
	 *
	 * @return WP_Comment
	 */
	protected function get_object( $id ) {
		return get_comment( $id );
	}

	public function set_manage_value_callback() {
		add_action( 'manage_comments_custom_column', [ $this, 'manage_value' ], 100, 2 );
	}

	/**
	 * @since 3.5
	 */
	public function get_table_attr_id() {
		return '#the-comment-list';
	}

	/**
	 * @param string $column_name
	 * @param int $id
	 */
	public function manage_value( $column_name, $id ) {
		echo $this->get_display_value_by_column_name( $column_name, $id );
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

	public function get_table_url() {
		return admin_url( 'comments.php' );
	}

	/**
	 * @return WP_Comments_List_Table
	 * @deprecated NEWVERSION
	 */
	public function get_list_table() {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return ( new AC\ListTableFactory() )->create_comment_table( $this->get_screen_id() );
	}

}