<?php

namespace AC\ListScreenFactory;

use AC\ColumnCollection;
use AC\ColumnFactory;
use AC\ListScreen;
use AC\ListScreenFactoryInterface;
use AC\Type\ListScreenData;
use AC\Type\ListScreenId;

class ListScreenFactory implements ListScreenFactoryInterface {

	/**
	 * @var string
	 */
	protected $default_list_screen = ListScreen\Post::CLASS;

	/**
	 * @var array
	 */
	// TODO: remove?
//	protected $list_screens = [
//		ListScreen\User::NAME    => ListScreen\User::CLASS,
//		ListScreen\Media::NAME   => ListScreen\Media::CLASS,
//		ListScreen\Comment::NAME => ListScreen\Comment::CLASS,
//	];

	/**
	 * @var ColumnFactory
	 */
	private $column_factory;

	public function __construct( ColumnFactory $column_factory ) {
		$this->column_factory = $column_factory;
	}

	public function create( ListScreenData $data ) {

		$id = $data->has( ListScreenData::PARAM_ID )
			? new ListScreenId( $data->get( ListScreenData::PARAM_ID ) )
			: null;

		$settings = $data->has( ListScreenData::PARAM_SETTINGS )
			? $data->get( ListScreenData::PARAM_SETTINGS )
			: [];

		switch ( $data->get( 'key' ) ) {
			case ListScreen\User::NAME :
				$list_screen = new ListScreen\User( $settings, $id );
				break;
			case ListScreen\Media::NAME :
				$list_screen = new ListScreen\Media( $settings, $id );
				break;
			case ListScreen\Comment::NAME :
				$list_screen = new ListScreen\Comment( $settings, $id );
				break;
			default :
				$list_screen = new $this->default_list_screen( $data->get( 'key' ), $settings, $id );
		}

		// TODO: columns can not be injected, becayse they are dependent on a initiated ListScreen object..
		if ( $data->has( ListScreenData::PARAM_COLUMNS ) ) {
			$list_screen->set_columns( $this->create_columns( $data->get( ListScreenData::PARAM_COLUMNS ), $list_screen ) );
		}

		return $list_screen;
	}

	/**
	 * @param array $data
	 * @param ListScreen $list_screen
	 *
	 * @return ColumnCollection
	 */
	private function create_columns( array $data, ListScreen $list_screen ) {
		$columns = new ColumnCollection();

		foreach ( $data as $column_name => $column_data ) {
			$column = $this->column_factory->create( $column_data + [ 'name' => $column_name ], $list_screen );

			if ( null === $column ) {
				continue;
			}

			$columns->add( $column );
		}

		return $columns;
	}

}