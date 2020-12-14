<?php

namespace AC\Column\Post;

use AC\Column;
use AC\Settings;

class Attachment extends Column {

	const TYPE = 'column-attachment';

	public function __construct( $id, array $settings = [] ) {
		parent::__construct( self::TYPE, $id, __( 'Attachments', 'codepress-admin-columns' ), $settings );
	}

	public function get_raw_value( $post_id ) {
		return $this->get_attachment_ids( $post_id );
	}

	/**
	 * @param $post_id
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

	// TODO
//	public function register_settings() {
//		$this->add_setting( new Settings\Column\AttachmentDisplay() );
//	}

}