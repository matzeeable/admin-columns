<?php

namespace AC;

use AC\Admin\Page;
use AC\Admin\PageCollection;
use AC\Admin\Section;
use AC\Admin\SectionCollection;
use AC\Asset\Location;
use AC\Controller\ListScreenRequest;
use AC\Deprecated\Hooks;
use AC\ListScreenRepository\Storage;

class AdminFactory {

	/**
	 * @var Storage
	 */
	protected $storage;

	/**
	 * @var Location\Absolute
	 */
	protected $location;

	/**
	 * @var ListScreenFactory
	 */
	private $list_screen_factory;

	/**
	 * @var ColumnTypesRepository
	 */
	private $column_types_repository;

	/**
	 * @var ColumnFactory
	 */
	private $column_factory;

	/**
	 * @var Hooks
	 */
	private $hooks;

	public function __construct(
		Storage $storage,
		Location\Absolute $location,
		ListScreenFactory $list_screen_factory,
		ColumnTypesRepository $column_types_repository,
		ColumnFactory $column_factory,
		Hooks $hooks
	) {
		$this->storage = $storage;
		$this->location = $location;
		$this->list_screen_factory = $list_screen_factory;
		$this->column_types_repository = $column_types_repository;
		$this->column_factory = $column_factory;
		$this->hooks = $hooks;
	}

	/**
	 * @return Page\Columns
	 */
	protected function create_columns_page() {
		$list_screen_controller = new ListScreenRequest(
			new Request(),
			$this->storage,
			new Preferences\Site( 'settings' ),
			$this->list_screen_factory,
			new ListScreenTypeRepository(),
			new DefaultColumnsRepository()
		);

		return new Page\Columns(
			$list_screen_controller,
			$this->location,
			new DefaultColumnsRepository(),
			new Section\Partial\Menu( $list_screen_controller, false ),
			$this->storage,
			$this->list_screen_factory,
			$this->column_types_repository,
			$this->column_factory
		);
	}

	protected function create_section_general() {
		return new Section\General( [
			new Section\Partial\ShowEditButton(),
		] );
	}

	/**
	 * @return Page\Settings
	 */
	protected function create_settings_page() {
		$sections = new SectionCollection();
		$sections->add( $this->create_section_general() )
		         ->add( new Section\Restore() );

		return new Page\Settings( $sections );
	}

	/**
	 * @return PageCollection
	 */
	protected function get_pages() {
		$pages = new PageCollection();
		$pages->add( $this->create_columns_page() )
		      ->add( $this->create_settings_page() )
		      ->add( new Page\Addons( $this->location, new Integrations() ) );

		if ( $this->hooks->get_count() > 0 ) {
			$pages->add( new Page\Help( $this->hooks, $this->location ) );
		}

		return $pages;
	}

	/**
	 * @return Admin
	 */
	public function create() {
		return new Admin(
			'options-general.php',
			'admin_menu',
			$this->get_pages(),
			$this->location
		);
	}

}