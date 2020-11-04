<?php

namespace AC\Column\Post;

use AC\Column;
use AC\Column\MetaKey;

class PageTemplate extends Column implements MetaKey {

	const TYPE = 'column-page_template';

	/**
	 * @var string
	 */
	private $post_type;

	public function __construct( $name, $post_type, array $data = [] ) {
		parent::__construct( self::TYPE, $name, $data );

		$this->post_type = $post_type;

		// TODO: remove
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
		if ( ! function_exists( 'get_page_templates' ) ) {
			return [];
		}

		return get_page_templates( null, $this->post_type );
	}

}