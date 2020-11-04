<?php

namespace AC\ListScreen;

use AC;
use AC\ListScreen;
use AC\MetaType;
use AC\Type\ListScreenId;
use AC\Type\ListScreenLabel;
use AC\Type\Screen;
use ReflectionException;
use WP_Comment;
use WP_Comments_List_Table;

class Comment extends ListScreen {

	const NAME = 'wp-comments';

	public function __construct( AC\ColumnCollection $columns, array $settings = [], ListScreenId $id = null ) {
		parent::__construct(
			$columns,
			new MetaType( MetaType::COMMENT ),
			new Screen( 'edit-comments', 'edit-comments', self::NAME ),
			new ListScreenLabel( __( 'Comment' ), __( 'Comments' ) ),
			$settings,
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

	public function get_table_url() {
		return admin_url( 'comments.php' );
	}

	/**
	 * @return WP_Comments_List_Table
	 * @deprecated NEWVERSION
	 */
	public function get_list_table() {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return ( new AC\ListTableFactory() )->create_comment_table( $this->screen->get_id() );
	}

}