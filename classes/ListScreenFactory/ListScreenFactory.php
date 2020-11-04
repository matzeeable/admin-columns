<?php

namespace AC\ListScreenFactory;

use AC\ColumnCollection;
use AC\ColumnFactory;
use AC\ListScreen;
use AC\ListScreenFactoryInterface;
use AC\MetaType;
use AC\Type\ListScreenData;
use AC\Type\ListScreenId;

class ListScreenFactory implements ListScreenFactoryInterface {

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

		switch ( $data->get( ListScreenData::PARAM_KEY ) ) {
			case ListScreen\User::NAME :
				return new ListScreen\User( $this->create_columns( $data, new MetaType( MetaType::USER ) ), $settings, $id );
			case ListScreen\Media::NAME :
				return new ListScreen\Media( $this->create_columns( $data, new MetaType( MetaType::POST ) ), $settings, $id );
			case ListScreen\Comment::NAME :
				return new ListScreen\Comment( $this->create_columns( $data, new MetaType( MetaType::COMMENT ) ), $settings, $id );
			default :
				return new ListScreen\Post( $data->get( ListScreenData::PARAM_KEY ), $this->create_columns( $data, new MetaType( MetaType::POST ) ), $settings, $id );
		}
	}

	/**
	 * @param ListScreenData $data
	 * @param MetaType $meta_type
	 *
	 * @return ColumnCollection
	 */
	private function create_columns( ListScreenData $data, MetaType $meta_type ) {
		$columns = new ColumnCollection();

		if ( $data->has( ListScreenData::PARAM_COLUMNS ) ) {

			$list_key = $data->get( ListScreenData::PARAM_KEY );

			foreach ( $data->get( ListScreenData::PARAM_COLUMNS ) as $column_name => $settings ) {
				$data = $settings + [
						'name'      => $column_name,
						'list_key'  => $list_key,
						'post_type' => $list_key,
						'taxonomy'  => str_replace( 'wp-taxonomy_', '', $list_key ),
						'meta_type' => $meta_type,
					];

				$column = $this->column_factory->create( $data );

				if ( null === $column ) {
					continue;
				}

				$columns->add( $column );
			}
		}

		return $columns;
	}

}