<?php

namespace AC\Controller;

use AC\Ajax;
use AC\ColumnFactory;
use AC\ColumnTypesRepository;
use AC\Controller\ColumnRequest\Refresh;
use AC\Controller\ColumnRequest\Select;
use AC\Controller\ListScreen\Save;
use AC\ListScreenRepository\Storage;
use AC\Registrable;
use AC\Request;
use LogicException;

class AjaxColumnRequest implements Registrable {

	/**
	 * @var Storage
	 */
	private $storage;

	/**
	 * @var ColumnFactory
	 */
	private $column_factory;

	/**
	 * @var ColumnTypesRepository
	 */
	private $column_types_repository;

	/**
	 * @var Request
	 */
	private $request;

	public function __construct(
		Storage $storage,
		ColumnFactory $column_factory,
		ColumnTypesRepository $column_types_repository,
		Request $request
	) {
		$this->storage = $storage;
		$this->column_factory = $column_factory;
		$this->column_types_repository = $column_types_repository;
		$this->request = $request;
	}

	public function register() {
		$this->get_ajax_handler()->register();
	}

	/**
	 * @return Ajax\Handler
	 */
	private function get_ajax_handler() {
		$handler = new Ajax\Handler();
		$handler
			->set_action( 'ac-columns' )
			->set_callback( [ $this, 'handle_ajax_request' ] );

		return $handler;
	}

	public function handle_ajax_request() {
		$this->get_ajax_handler()->verify_request();

		switch ( $this->request->get( 'id' ) ) {
			case 'save':
				( new Save( $this->storage ) )->request( $this->request );
				break;
			case 'select':
				( new Select( $this->column_factory, $this->column_types_repository ) )->request( $this->request );
				break;
			case 'refresh':
				( new Refresh( $this->column_factory ) )->request( $this->request );
				break;
		}

		throw new LogicException( 'Could not handle request.' );
	}

}