<?php

/**
 * Upgrade
 *
 * Class largely based on code from Elliot Condon ( props goes to him )
 *
 * @since 2.0.0
 */
class CPAC_Upgrade {

	function __construct() {

		// DEV
		update_option( 'cpac_version', '1.0.0' );

		// run upgrade based on version
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 11 );
		add_action( 'wp_ajax_cpac_upgrade', array( $this, 'upgrade' ) );
	}

	/**
	 * Add submenu page
	 *
	 * @since 2.0.0
	 */
	public function admin_menu() {

		$page = add_submenu_page( 'codepress-admin-columns', __( 'Upgrade', 'cpac' ), __( 'Upgrade', 'cpac' ), 'manage_options', 'cpac-upgrade', array( $this, 'start_upgrade' ) );

		add_action( "admin_print_scripts-{$page}", array( $this, 'admin_scripts' ) );
	}

	/**
	 * Scripts
	 *
	 * @since 2.0.0
	 */
	public function admin_scripts() {
		wp_enqueue_script( 'cpac-upgrade', CPAC_URL . 'assets/js/upgrade.js', array( 'jquery' ), CPAC_VERSION );
		wp_enqueue_style( 'cpac-admin', CPAC_URL . 'assets/css/admin-column.css', array(), CPAC_VERSION, 'all' );

		// javascript translations
		wp_localize_script( 'cpac-upgrade', 'cpac_upgrade_i18n', array(
			'complete'		=> __( 'Upgrade Complete!', 'cpac' ),
			'error'			=> __( 'Error', 'cpac' ),
			'major_error'	=> __( 'Sorry. Something went wrong during the upgrade process. Please report this on the support forum.', 'cpac' )
		));
	}

	/**
	 * init
	 *
	 * @since 2.0.0
	 */
	public function init() {

		$version = get_option( 'cpac_version', false );

		// Maybe upgrade?
		if ( $version ) {

			// run every upgrade
			if ( $version < CPAC_VERSION ) {

				// flush this transient so new custom columns get's added.
				delete_transient( 'cpac_custom_columns' );
			}

			// run only when upgrade is needed
			if ( $version < CPAC_UPGRADE_VERSION ) {

				// display upgrade message on every page except upgrade page itself
				if ( ! ( isset( $_REQUEST['page'] ) && 'cpac-upgrade' === $_REQUEST['page'] ) ) {

					$message = 	__( 'Admin Columns', 'cpac' ) . ' v' . CPAC_VERSION . ' ' .
								__( 'requires a database upgrade','cpac' ) .
								' (<a class="thickbox" href="' . admin_url() .
								'plugin-install.php?tab=plugin-information&plugin=codepress-admin-columns&section=changelog&TB_iframe=true&width=640&height=559">' .
								__( 'why?', 'cpac' ) .'</a>). '	.
								__( "Please", 'cpac' ) .' <a href="http://codex.wordpress.org/Backing_Up_Your_Database">' .
								__( "backup your database", 'cpac' ) .'</a>, '.
								__( "then click", 'cpac' ) . ' <a href="' . admin_url() . 'admin.php?page=cpac-upgrade" class="button">' .
								__( "Upgrade Database", 'cpac' ) . '</a>';

					cpac_admin_message( $message, 'updated' );
				}
			}

			// run when NO upgrade is needed
			elseif ( $version < CPAC_VERSION ) {

				update_option( 'cpac_version', CPAC_VERSION );
			}

		}

		// Fresh install
		else {
			update_option( 'cpac_version', CPAC_VERSION );
		}
	}

	/**
	 * Init Upgrade Process
	 *
	 * @since 2.0.0
	 */
	public function upgrade() {

		// vars
		$return = array(
			'status'	=>	false,
			'message'	=>	"",
			'next'		=>	false,
		);

		$version = $_POST['version'];

		// versions
		switch( $version ) {

			case '2.0.0' :

				$old_settings = get_option( 'cpac_options' );

				// old settings
				if ( ! empty( $old_settings['columns'] ) ) {

					foreach ( $old_settings['columns'] as $storage_key => $old_columns ){

						$columns = array();

						if ( $old_columns ) {

							// used to determine clone ID
							$tax_count 	= null;
							$post_count = null;
							$meta_count = null;

							foreach ( $old_columns as $old_column_name => $old_column_settings ) {

								// convert old settings to new
								$settings = array_merge( $old_column_settings, array(
									'type' 	=> $old_column_name,
						            'clone' => ''
								) );

								// set name
								$name = $old_column_name;

								// convert: Users
								if ( 'wp-users' == $storage_key ) {

									// is user postcount?
									if ( strpos( $old_column_name, 'column-user_postcount-' ) !== false ) {
										$settings['type']  		= 'column-user_postcount';
										$settings['clone'] 		= $post_count;
										$settings['post_type'] 	= str_replace( 'column-user_postcount-', '', $old_column_name );

										$name = $post_count ? $settings['type'] . '-' . $settings['clone'] : $settings['type'];
										$post_count++;
									}
								}

								// convert: Media
								elseif ( 'wp-media' == $storage_key ) {

									if ( 'column-filesize' == $old_column_name ) {
										$name = 'column-file_size';
										$settings['type'] = $name;
									}
									// is EXIF data?
									elseif ( strpos( $old_column_name, 'column-image-' ) !== false ) {
										$name = 'column-exif_data';
										$settings['type'] = $name;
										$settings['exif_datatype'] = str_replace( 'column-image-', '', $old_column_name );
									}
									elseif ( 'column-file_paths' == $old_column_name ) {
										$name = 'column-available_sizes';
										$settings['type'] = $name;
									}
								}

								// convert: Comments
								elseif ( 'wp-comments' == $storage_key ) {

									if ( 'column-author_author' == $old_column_name ) {
										$name = 'column-author';
										$settings['type'] = $name;
									}
								}

								// convert: Posts
								else {

									if ( 'column-attachment-count' == $old_column_name ) {
										$name = 'column-attachment_count';
										$settings['type'] = $name;
									}
									elseif ( 'column-author-name' == $old_column_name ) {
										$name = 'column-author_name';
										$settings['type'] = $name;
										$settings['display_author_as'] = $old_column_settings['display_as'];
									}
									elseif ( 'column-before-moretag' == $old_column_name ) {
										$name = 'column-before_moretag';
										$settings['type'] = $name;
									}
									elseif ( 'column-comment-count' == $old_column_name ) {
										$name = 'column-comment_count';
										$settings['type'] = $name;
										$settings['comment_status'] = 'total_comments';
									}
									elseif ( 'column-comment-status' == $old_column_name ) {
										$name = 'column-comment_status';
										$settings['type'] = $name;
									}
									elseif ( 'column-ping-status' == $old_column_name ) {
										$name = 'column-ping_status';
										$settings['type'] = $name;
									}
									elseif ( 'column-page-slug' == $old_column_name ) {
										$name = 'column-slug';
										$settings['type'] = $name;
									}
									elseif ( 'column-page-template' == $old_column_name ) {
										$name = 'column-page_template';
										$settings['type'] = $name;
									}
								}

								// convert: Applies to all storage types

								// is taxonomy?
								if ( strpos( $old_column_name, 'column-taxonomy-' ) !== false ) {
									$settings['type']  		= 'column-taxonomy';
									$settings['clone'] 		= $tax_count;
									$settings['taxonomy'] 	= str_replace( 'column-taxonomy-', '', $old_column_name );

									$name = $tax_count ? $settings['type'] . '-' . $settings['clone'] : $settings['type'];
									$tax_count++;
								}
								// is custom field?
								elseif ( strpos( $old_column_name, 'column-meta-' ) !== false ) {
									$settings['type']  = 'column-meta';
									$settings['clone'] = str_replace( 'column-meta-', '', $old_column_name );

									$name = $meta_count ? $settings['type'] . '-' . $settings['clone'] : $settings['type'];
									$meta_count++;
								}
								elseif ( 'column-word-count' == $old_column_name ) {
									$name = 'column-word_count';
									$settings['type'] = $name;
								}

								// add to column set
								$columns[ $name ] = $settings;
							}

							update_option( "cpac_options_{$storage_key}", $columns );
						}
					}
				}

				// update version
				update_option( 'cpac_version', $version );

				$return = array(
			    	'status'	=>	true,
					'message'	=>	__( "Migrating Column Settings", 'cpac' ) . '...',
					'next'		=>	false,
			    );

			break;

		}

		// return json
		echo json_encode( $return );
		die;
	}

	/*
	* Starting points of the upgrade process
	*
	* @since 2.0.0
	*/
	public function start_upgrade() {

		$version 	= get_option( 'cpac_version', '1.0.0' );
		$next 		= false;

		// list of starting points
		if( $version < '2.0.0' ) {
			$next = '2.0.0';
		}

		// Run upgrade?
		if( $next ) : ?>
		<script type="text/javascript">
			run_upgrade("<?php echo $next; ?>");
		</script>
		<?php

		// No update required
		else :
			echo '<p>No Upgrade Required</p>';
		endif;
	}

}