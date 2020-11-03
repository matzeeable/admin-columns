<?php

namespace AC\ListScreenFactory;

use AC\ColumnCollection;
use AC\ColumnFactory;
use AC\ListScreen;
use AC\ListScreenFactoryInterface;
use AC\ListScreenPost;
use AC\MetaType;
use AC\Type\ListScreenData;
use AC\Type\ListScreenId;

class ListScreenFactory implements ListScreenFactoryInterface {

	/**
	 * @var string
	 */
	protected $default_list_screen = ListScreen\Post::CLASS;

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

		// TODO: columns can not be injected into the constructor of a ListScreen object, because they are dependent on the same initiated ListScreen object..
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
	private function create_columns( array $column_data, ListScreen $list_screen ) {
		$columns = new ColumnCollection();

		foreach ( $column_data as $column_name => $settings ) {
			$data = $settings + [
					'name'      => $column_name,
					'meta_type' => new MetaType( $list_screen->get_meta_type() ),
					'post_type' => $list_screen instanceof ListScreenPost ? $list_screen->get_post_type() : null,
					'taxanomy'  => method_exists( $list_screen, 'get_taxanomy' ) ? $list_screen->get_taxanomy() : null
				];

			$column = $this->column_factory->create( $list_screen->get_key(), $data );

			if ( null === $column ) {
				continue;
			}

			$columns->add( $column );
		}

		return $columns;
	}

}