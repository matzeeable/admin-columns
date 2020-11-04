<?php

namespace AC\Controller;

use AC;
use AC\DefaultColumnsRepository;
use AC\ListScreenFactory;
use AC\Registrable;
use AC\Request;
use AC\Type\ListScreenData;

class DefaultColumns implements Registrable {

	const ACTION_KEY = 'save-default-headings';

	const LISTSCREEN_KEY = 'list_screen';
	const SCREEN_ID = 'screen_id';

	/** @var string */
	private $list_screen_key;

	/** @var Request */
	private $request;

	/** @var DefaultColumnsRepository */
	private $default_columns;

	/**
	 * @var ListScreenFactory
	 */
	private $list_screen_factory;

	public function __construct(
		Request $request,
		DefaultColumnsRepository $default_columns,
		ListScreenFactory $list_screen_factory
	) {
		$this->request = $request;
		$this->default_columns = $default_columns;
		$this->list_screen_factory = $list_screen_factory;
	}

	public function register() {
		add_action( 'admin_init', [ $this, 'handle_request' ] );
	}

	public function handle_request() {
		if ( '1' !== $this->request->get( self::ACTION_KEY ) ) {
			return;
		}

		if ( ! current_user_can( AC\Capabilities::MANAGE ) ) {
			return;
		}

		$this->list_screen_key = $this->request->get( self::LISTSCREEN_KEY );

		// TODO: implement sending the SCREEN_ID with the request
		$screen_id = $this->request->get( self::SCREEN_ID );

		// TODO: remove
		$list_screen = $this->list_screen_factory->create( new ListScreenData( [
			ListScreenData::PARAM_KEY => $this->request->get( self::LISTSCREEN_KEY )
		] ) );

		if ( ! $list_screen ) {
			return;
		}
		$screen_id = $list_screen->get_screen()->get_id();

		// Save an empty array in case the hook does not run properly.
		$this->default_columns->update( $this->list_screen_key, [] );

		// Our custom columns are set at priority 200. Before they are added we need to store the default column headings.
		add_filter( "manage_{$screen_id}_columns", [ $this, 'save_headings' ], 199 );

		// no render needed
		ob_start();
	}

	public function save_headings( $columns ) {
		ob_end_clean();

		$this->default_columns->update( $this->list_screen_key, $columns && is_array( $columns ) ? $columns : [] );

		exit( 'ac_success' );
	}

}