<?php

namespace AC\Meta;

class QueryMeta extends Query {

	/**
	 * @param string $meta_type
	 * @param string $meta_key
	 * @param string|null $post_type
	 */
	public function __construct( $meta_type, $meta_key, $post_type = null ) {
		parent::__construct( $meta_type );

		$this->join_where( 'meta_key', $meta_key );

		if ( $post_type ) {
			$this->where_post_type( $post_type );
		}
	}

}