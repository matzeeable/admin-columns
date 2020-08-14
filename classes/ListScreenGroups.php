<?php

namespace AC;

class ListScreenGroups {

	const POST_TYPE = 'post';
	const USER = 'user';
	const MEDIA = 'media';
	const COMMENT = 'comment';
	const LINK = 'link';

	/**
	 * @return Groups
	 */
	public static function get_groups() {
		$groups = new Groups();

		$groups->register_group( self::POST_TYPE, __( 'Post Type', 'codepress-admin-columns' ), 5 );
		$groups->register_group( self::USER, __( 'Users' ) );
		$groups->register_group( self::MEDIA, __( 'Media' ) );
		$groups->register_group( self::COMMENT, __( 'Comments' ) );
		$groups->register_group( self::LINK, __( 'Links' ), 15 );

		do_action( 'ac/list_screen_groups', $groups );

		return $groups;
	}

}