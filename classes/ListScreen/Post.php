<?php

namespace AC\ListScreen;

use AC\ListScreenPost;
use AC\ListTableFactory;
use AC\Type\ListScreenId;
use AC\Type\Screen;
use ReflectionException;
use WP_Posts_List_Table;

class Post extends ListScreenPost {

	const NAME = 'POST';

	public function __construct( $post_type, ListScreenId $id = null ) {
		parent::__construct(
			$post_type,
			new Screen( 'edit', 'edit-' . $post_type, $post_type ),
			null,
			$id
		);
	}

	/**
	 * @see WP_Posts_List_Table::column_default
	 */
	public function register() {
		add_action( "manage_{$this->post_type}_posts_custom_column", [ $this, 'manage_value' ], 100, 2 );
	}

	public function get_table_url() {
		return add_query_arg( [ 'post_type' => $this->get_post_type() ], admin_url( 'edit.php' ) );
	}

	/**
	 * @return string|false
	 */
	public function get_label() {
		return $this->get_post_type_label_var( 'name' );
	}

	/**
	 * @return false|string
	 */
	public function get_singular_label() {
		return $this->get_post_type_label_var( 'singular_name' );
	}

	/**
	 * @param $column_name
	 * @param $id
	 *
	 * @since 2.4.7
	 */
	public function manage_value( $column_name, $id ) {
		echo $this->get_display_value_by_column_name( $column_name, $id );
	}

	/**
	 * @throws ReflectionException
	 */
	protected function register_column_types() {
		parent::register_column_types();

		$this->register_column_types_from_dir( 'AC\Column\Post' );
	}

	/**
	 * @return WP_Posts_List_Table
	 * @deprecated NEWVERSION
	 */
	protected function get_list_table() {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return ( new ListTableFactory() )->create_post_table( $this->screen->get_id() );
	}

}