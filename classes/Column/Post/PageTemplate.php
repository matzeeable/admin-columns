<?php

namespace AC\Column\Post;

use AC\Column;
use AC\Column\MetaKey;
use AC\Settings\ColumnSettingsCollection;

class PageTemplate extends Column implements MetaKey {

	const TYPE = 'column-page_template';

	/**
	 * @var string
	 */
	private $post_type;

	public function __construct( $name, $post_type, ColumnSettingsCollection $settings ) {
		parent::__construct( self::TYPE, $name, $settings );

		$this->post_type = $post_type;
	}

	public function get_meta_key() {
		return '_wp_page_template';
	}

	public function get_meta_value( $id ) {
		return get_post_meta( $id, $this->get_meta_key(), true );
	}

	function get_value( $id ) {
		$template = array_search( $this->get_meta_value( $id ), $this->get_page_templates() );

		if ( ! $template ) {
			return $this->get_empty_char();
		}

		return $template;
	}

	/**
	 * @return array
	 */
	public function get_page_templates() {
		if ( ! function_exists( 'get_page_templates' ) ) {
			return [];
		}

		return get_page_templates( null, $this->post_type );
	}

}