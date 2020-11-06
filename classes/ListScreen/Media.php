<?php

namespace AC\ListScreen;

use AC;
use AC\Type\ListScreenId;
use AC\Type\ListScreenLabel;
use AC\Type\Screen;
use ReflectionException;
use WP_Media_List_Table;

class Media extends AC\ListScreenPost {

	const NAME = 'wp-media';

	public function __construct( AC\ColumnCollection $columns, array $settings = [], ListScreenId $id = null ) {
		parent::__construct(
			'attachment',
			new Screen( 'upload', 'upload', self::NAME ),
			$columns,
			new ListScreenLabel( __( 'Media' ), __( 'Media' ) ),
			$settings,
			$id
		);
	}

	public function register() {
		add_action( 'manage_media_custom_column', [ $this, 'manage_value' ], 100, 2 );
	}

	public function get_table_url() {
		return add_query_arg( [ 'mode' => 'list' ], admin_url( 'upload.php' ) );
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

	protected function register_column_types() {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

//		parent::register_column_types();
//
//		$this->register_column_types_from_dir( 'AC\Column\Media' );
	}

	/**
	 * @return WP_Media_List_Table
	 * @deprecated NEWVERSION
	 */
	public function get_list_table() {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return ( new AC\ListTableFactory() )->create_media_table( $this->screen->get_id() );
	}

	/**
	 * @param int $id
	 *
	 * @return string
	 * @deprecated NEWVERSION
	 */
	// TODO: check usages in pro
	public function get_single_row( $id ) {
		_deprecated_function( __METHOD__, 'NEWVERSION' );
		// Author column depends on this global to be set.
		global $authordata;

		// Title for some columns can only be retrieved when post is set globally
		if ( ! isset( $GLOBALS['post'] ) ) {
			$GLOBALS['post'] = get_post( $id );
		}

		$authordata = get_userdata( get_post_field( 'post_author', $id ) );

		ob_start();
		$this->get_list_table()->single_row( $this->get_object( $id ) );

		return ob_get_clean();
	}

}