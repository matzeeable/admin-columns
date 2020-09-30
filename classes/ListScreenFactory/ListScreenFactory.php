<?php

namespace AC\ListScreenFactory;

use AC\ColumnCollection;
use AC\ColumnFactory;
use AC\ListScreen;
use AC\ListScreenFactoryInterface;
use AC\Type\ListScreenData;
use AC\Type\ListScreenId;
use WP_Screen;

class ListScreenFactory implements ListScreenFactoryInterface {

	/**
	 * @var string
	 */
	protected $default_list_screen = ListScreen\Post::CLASS;

	/**
	 * @var array
	 */
	protected $list_screens = [
		ListScreen\User::NAME    => ListScreen\User::CLASS,
		ListScreen\Media::NAME   => ListScreen\Media::CLASS,
		ListScreen\Comment::NAME => ListScreen\Comment::CLASS,
	];

	/**
	 * @var ColumnFactory
	 */
	private $column_factory;

	public function __construct( ColumnFactory $column_factory ) {
		$this->column_factory = $column_factory;
	}

	public function create( ListScreenData $data ) {
		$key = $data->get( 'key' );

		/** @var ListScreen $list_screen */
		if ( isset( $this->list_screens[ $key ] ) ) {
			$list_screen = new $this->list_screens[$key]();
		} else {
			$list_screen = new $this->default_list_screen( $key );
		}

		if ( $data->has( ListScreenData::PARAM_ID ) ) {
			$list_screen->set_id( new ListScreenId( $data->get( ListScreenData::PARAM_ID ) ) );
		}

		if ( $data->has( ListScreenData::PARAM_SETTINGS ) ) {
			$list_screen->set_settings( $data->get( ListScreenData::PARAM_SETTINGS ) );
		}

		$columns = new ColumnCollection();

		if ( $data->has( ListScreenData::PARAM_COLUMNS ) ) {
			foreach ( $data->get( ListScreenData::PARAM_COLUMNS ) as $column_name => $column_data ) {
				$column = $this->column_factory->create( $column_data + [ 'name' => $column_name ], $list_screen );

				if ( null === $column ) {
					continue;
				}

				$columns->add( $column );
			}
		}

		$list_screen->set_columns( $columns );

		return $list_screen;
	}

	public function create_by_screen( WP_Screen $wp_screen ) {
		switch ( $wp_screen->base ) {
			case 'edit' :
				return $wp_screen->post_type
					? $this->create( new ListScreenData( [ ListScreenData::PARAM_KEY => $wp_screen->post_type ] ) )
					: null;
			case 'users' :
				// TODO: remove 'delete'
				return 'users' === $wp_screen->id && 'delete' !== filter_input( INPUT_GET, 'action' )
					? $this->create( new ListScreenData( [ ListScreenData::PARAM_KEY => ListScreen\User::NAME ] ) )
					: null;
			case 'upload' :
				return 'upload' === $wp_screen->id
					? $this->create( new ListScreenData( [ ListScreenData::PARAM_KEY => ListScreen\Media::NAME ] ) )
					: null;
			case 'edit-comments' :
				return 'edit-comments' === $wp_screen->id
					? $this->create( new ListScreenData( [ ListScreenData::PARAM_KEY => ListScreen\Comment::NAME ] ) )
					: null;
			default :
				return null;
		}
	}

}