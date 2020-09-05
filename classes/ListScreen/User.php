<?php

namespace AC\ListScreen;

use AC;
use AC\ListScreen;
use AC\MetaType;
use AC\Type\ListScreenId;
use AC\Type\ListScreenKey;
use AC\Type\TableId;
use ReflectionException;
use WP_User;
use WP_Users_List_Table;

class User extends ListScreen {

	const NAME = 'wp-users';

	public function __construct( ListScreenId $id = null ) {
		parent::__construct(
			new ListScreenKey( self::NAME ),
			new MetaType( MetaType::USER ),
			new TableId( 'users', 'users' ),
			__( 'Users' ),
			$id
		);
	}

	public function register() {
		add_filter( 'manage_users_custom_column', [ $this, 'manage_value' ], 100, 3 );
	}

	/**
	 * @param string $value
	 * @param string $column_name
	 * @param int    $user_id
	 *
	 * @return string
	 * @since 2.0.2
	 */
	public function manage_value( $value, $column_name, $user_id ) {
		return $this->get_display_value_by_column_name( $column_name, $user_id, $value );
	}

	/**
	 * @param int $id
	 *
	 * @return WP_User
	 */
	protected function get_object( $id ) {
		return get_userdata( $id );
	}

	public function get_table_url() {
		return admin_url( 'users.php' );
	}

	/**
	 * @throws ReflectionException
	 */
	protected function register_column_types() {
		$this->register_column_type( new AC\Column\CustomField );
		$this->register_column_type( new AC\Column\Actions );

		$this->register_column_types_from_dir( 'AC\Column\User' );
	}

	/**
	 * @param int $id
	 *
	 * @return string HTML
	 * @deprecated NEWVERSION
	 * @since      3.0
	 */
	public function get_single_row( $id ) {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return $this->get_list_table()->single_row( $this->get_object( $id ) );
	}

	/**
	 * @return WP_Users_List_Table
	 * @deprecated NEWVERSION
	 */
	public function get_list_table() {
		_deprecated_function( __METHOD__, 'NEWVERSION' );

		return ( new AC\ListTableFactory() )->create_user_table( $this->table_id->get_screen_id() );
	}

}