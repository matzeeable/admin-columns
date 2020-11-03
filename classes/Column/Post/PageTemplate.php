<?php

namespace AC\Column\Post;

use AC\Column;
use AC\Column\MetaKey;

class PageTemplate extends Column implements MetaKey {

	const TYPE = 'column-page_template';

	public function __construct( $name, $post_type, array $data = [] ) {
		parent::__construct( self::TYPE, $name, $data );

		$this->set_label( __( 'Page Template', 'codepress-admin-columns' ) );
	}

	public function get_meta_key() {
		return '_wp_page_template';
	}

	function get_value( $post_id ) {
		$template = array_search( $this->get_raw_value( $post_id ), $this->get_page_templates() );

		if ( ! $template ) {
			return $this->get_empty_char();
		}

		return $template;
	}

	/**
	 * @return array
	 */
	public function get_page_templates() {
		global $wp_version;

		if ( ! function_exists( 'get_page_templates' ) ) {
			return [];
		}

		if ( version_compare( $wp_version, '4.7', '>=' ) ) {
			return get_page_templates( null, $this->get_post_type() );
		}

		return get_page_templates();
	}

}