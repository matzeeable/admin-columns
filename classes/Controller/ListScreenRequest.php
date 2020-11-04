<?php

namespace AC\Controller;

use AC\DefaultColumnsRepository;
use AC\ListScreen;
use AC\ListScreenFactory;
use AC\ListScreenRepository\Storage;
use AC\ListScreenTypeRepository;
use AC\Preferences;
use AC\Request;
use AC\Type\ListScreenData;
use AC\Type\ListScreenId;

// TODO
class ListScreenRequest {

	/** @var Request */
	private $request;

	/** @var Storage */
	private $storage;

	/** @var Preferences */
	private $preference;

	/** @var bool */
	private $is_network;

	/**
	 * @var ListScreenTypeRepository
	 */
	private $list_screen_type_repository;

	/**
	 * @var ListScreenFactory
	 */
	private $list_screen_factory;

	/**
	 * @var DefaultColumnsRepository
	 */
	private $default_column_repository;

	public function __construct(
		Request $request,
		Storage $storage,
		Preferences $preference,
		ListScreenFactory $list_screen_factory,
		ListScreenTypeRepository $list_screen_type_repository,
		DefaultColumnsRepository $default_column_repository,
		$is_network = false
	) {
		$this->request = $request;
		$this->storage = $storage;
		$this->preference = $preference;
		$this->list_screen_factory = $list_screen_factory;
		$this->list_screen_type_repository = $list_screen_type_repository;
		$this->default_column_repository = $default_column_repository;
		$this->is_network = (bool) $is_network;
	}

	/**
	 * @param string $list_key
	 *
	 * @return bool
	 */
	private function exists_list_screen( $list_key ) {
		$list_screen = $this->list_screen_type_repository->find( $list_key );

		return $list_screen && $list_screen->is_network() === $this->is_network;
	}

	/**
	 * @param string $list_key
	 *
	 * @return ListScreen|null
	 */
	private function get_first_available_list_screen( $list_key ) {
		$list_screens = $this->storage->find_all( [ 'key' => $list_key ] );

		if ( $list_screens->count() < 1 ) {
			return null;
		}

		return $list_screens->get_first();
	}

	/**
	 * @return ListScreen
	 */
	// TODO: refactor. routing from the DB should be in a separate class.
	public function get_list_screen() {

		// Requested list ID
		$list_id = ListScreenId::is_valid_id( filter_input( INPUT_GET, 'layout_id' ) )
			? new ListScreenId( filter_input( INPUT_GET, 'layout_id' ) )
			: null;

		if ( $list_id && $this->storage->exists( $list_id ) ) {
			$list_screen = $this->storage->find( $list_id );

			if ( $list_screen && $this->exists_list_screen( $list_screen->get_key() ) ) {
				$this->preference->set( 'list_id', $list_screen->get_id()->get_id() );
				$this->preference->set( 'list_key', $list_screen->get_key() );

				return $list_screen;
			}
		}

		// Requested list type
		$list_key = filter_input( INPUT_GET, 'list_screen' );

		if ( $list_key && $this->exists_list_screen( $list_key ) ) {
			$this->preference->set( 'list_key', $list_key );

			$list_screen = $this->get_first_available_list_screen( $list_key );

			if ( $list_screen ) {
				$this->preference->set( 'list_id', $list_screen->get_id()->get_id() );

				return $list_screen;
			}

			// Initialize new
			return $this->create_list_screen( $list_key );
		}

		// Last visited ID
		$list_id_pref = $this->preference->get( 'list_id' );
		$list_id = ListScreenId::is_valid_id( $list_id_pref )
			? new ListScreenId( $list_id_pref )
			: null;

		if ( $list_id && $this->storage->exists( $list_id ) ) {
			$list_screen = $this->storage->find( $list_id );

			if ( $list_screen && $this->exists_list_screen( $list_screen->get_key() ) ) {
				return $list_screen;
			}
		}

		// Last visited Key
		$list_key = $this->preference->get( 'list_key' );

		// Load first available ID
		if ( $list_key && is_string( $list_key ) && $this->exists_list_screen( $list_key ) ) {
			$this->preference->set( 'list_key', $list_key );

			$list_screen = $this->get_first_available_list_screen( $list_key );

			if ( $list_screen ) {
				$this->preference->set( 'list_id', $list_screen->get_id()->get_id() );

				return $list_screen;
			}

			// Initialize new
			return $this->create_list_screen( $list_key );
		}

		// First visit to settings page
		$list_key = $this->get_first_available_list_screen_key();

		$this->preference->set( 'list_key', $list_key );

		$list_screen = $this->get_first_available_list_screen( $list_key );

		if ( $list_screen ) {
			$this->preference->set( 'list_id', $list_screen->get_id()->get_id() );

			return $list_screen;
		}

		// Initialize new
		return $this->create_list_screen( $list_key );
	}

	private function create_list_screen( $key ) {
		$columns = [];

		foreach ( $this->default_column_repository->find_all( $key ) as $name => $label ) {
			$columns[ $name ] = [
				'title' => $label,
				'label' => $label,
				'type'  => $name,
				'name'  => $name,
			];
		}

		return $this->list_screen_factory->create( new ListScreenData( [
			ListScreenData::PARAM_KEY     => $key,
			ListScreenData::PARAM_COLUMNS => $columns
		] ) );
	}

	/**
	 * @return string
	 */
	private function get_first_available_list_screen_key() {
		$types = $this->list_screen_type_repository->find_all( [ 'is_network' => $this->is_network ] );

		return current( $types )->get_key();
	}

}