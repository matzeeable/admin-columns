<?php

namespace AC;

use AC\Asset\Location\Absolute;
use AC\ListScreenRepository\Filter;
use AC\ListScreenRepository\Storage;
use AC\Table\Preference;
use AC\Type\ListScreenId;

class TableLoader implements Registrable {

	/**
	 * @var Storage
	 */
	private $storage;

	/**
	 * @var PermissionChecker
	 */
	private $permission_checker;

	/**
	 * @var Absolute
	 */
	private $location;

	/**
	 * @var Preference
	 */
	private $preference;

	public function __construct(
		Storage $storage,
		PermissionChecker $permission_checker,
		Absolute $location,
		Preference $preference
	) {
		$this->storage = $storage;
		$this->permission_checker = $permission_checker;
		$this->location = $location;
		$this->preference = $preference;
	}

	public function register() {
		add_action( 'ac/screen', [ $this, 'init' ] );
	}

	/**
	 * @return ListScreen|null
	 */
	private function get_requested_list_screen( $key ) {
		$list_id = null;

		// Requested
		if ( ListScreenId::is_valid_id( filter_input( INPUT_GET, 'layout' ) ) ) {
			$list_id = new ListScreenId( filter_input( INPUT_GET, 'layout' ) );
		}

		// Last visited
		if ( ! $list_id ) {
			$list_id_preference = $this->preference->get( $key );

			if ( ListScreenId::is_valid_id( $list_id_preference ) ) {
				$list_id = new ListScreenId( $list_id_preference );
			}
		}

		$list_screen = null;

		if ( $list_id ) {
			$list_screen = $this->storage->find( $list_id );
		}

		return $list_screen && $this->permission_checker->is_valid( wp_get_current_user(), $list_screen )
			? $list_screen
			: null;
	}

	public function init( Screen $screen ) {
		$key = $screen->get_list_screen_key();

		if ( ! $key ) {
			return;
		}

		$list_screen = $this->get_requested_list_screen( $key );

		// Get first available stored list screen
		if ( ! $list_screen ) {
			$list_screens = $this->storage->find_all( [
				'key'    => $key,
				'filter' => new Filter\Permission( $this->permission_checker ),
			] );

			if ( $list_screens->valid() ) {
				$list_screen = $list_screens->get_first();
			}
		}

		if ( ! $list_screen ) {
			// TODO: make sure we still add the edit columns icon to the table
			return;
		}

		$this->preference->set( $key, $list_screen->get_id()->get_id() );

		$table_screen = new Table\Screen( $this->location, $list_screen );
		$table_screen->register();

		// TODO: deprecated or remove
		do_action( 'ac/table' );
	}

}