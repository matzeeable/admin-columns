<?php

namespace AC;

use AC\Type\ListScreenId;
use AC\Type\ListScreenLabel;
use AC\Type\Screen;
use WP_Post;

abstract class ListScreenPost extends ListScreen {

	/**
	 * @var string
	 */
	protected $post_type;

	public function __construct( $post_type, Screen $screen, ListScreenLabel $label = null, array $settings = [], ListScreenId $id = null ) {
		parent::__construct( new MetaType( MetaType::POST ), $screen, $label, $settings, $id );

		$this->post_type = (string) $post_type;
	}

	/**
	 * @return string
	 */
	public function get_post_type() {
		return $this->post_type;
	}

	/**
	 * @param int $id
	 *
	 * @return WP_Post
	 */
	protected function get_object( $id ) {
		return get_post( $id );
	}

	/**
	 * @param string $var
	 *
	 * @return string|null
	 */
	protected function get_post_type_label_var( $var ) {
		$labels = get_post_type_labels( get_post_type_object( $this->get_post_type() ) );

		return isset( $labels->{$var} )
			? $labels->{$var}
			: null;
	}

	/**
	 * Register post specific columns
	 */
	protected function register_column_types() {
		$this->register_column_type( new Column\CustomField );
		$this->register_column_type( new Column\Actions );
	}

	/**
	 * @param string $post_type
	 *
	 * @return self
	 */
	protected function set_post_type( $post_type ) {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		$this->post_type = $post_type;

		return $this;
	}

}