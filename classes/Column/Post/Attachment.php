<?php

namespace AC\Column\Post;

use AC\Column;
use AC\Settings\ColumnSettingsCollection;

class Attachment extends Column {

	const TYPE = 'column-attachment';

	public function __construct( $id, ColumnSettingsCollection $settings = null ) {
		parent::__construct( self::TYPE, $id, $settings );
	}

	public function get_raw_value( $post_id ) {
		return $this->get_attachment_ids( $post_id );
	}

	/**
	 * @param int $post_id
	 *
	 * @return int[] Attachment ID's
	 */
	private function get_attachment_ids( $post_id ) {
		$attachment_ids = get_posts( [
			'post_type'      => 'attachment',
			'posts_per_page' => - 1,
			'post_status'    => null,
			'post_parent'    => $post_id,
			'fields'         => 'ids',
		] );

		if ( ! $attachment_ids ) {
			return [];
		}

		return $attachment_ids;
	}

}