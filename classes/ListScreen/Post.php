<?php

namespace AC\ListScreen;

use AC\ListScreenPost;
use AC\ListTableFactory;
use ReflectionException;
use WP_Posts_List_Table;

class Post extends ListScreenPost {

	public function __construct( $post_type ) {
		parent::__construct( $post_type );

		$this->set_group( 'post' )
		     ->set_key( $post_type );

		$this->heading_hook = "manage_edit-{$post_type}_columns";
	}

	/**
	 * @see WP_Posts_List_Table::column_default
	 */
	public function set_manage_value_callback() {
		add_action( "manage_{$this->post_type}_posts_custom_column", [ $this, 'manage_value' ], 100, 2 );
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

		return ( new ListTableFactory() )->create_post_table( $this->get_screen_id() );
	}

}