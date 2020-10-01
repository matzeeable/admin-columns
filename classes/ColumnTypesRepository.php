<?php

namespace AC;

class ColumnTypesRepository {

	/**
	 * @var DefaultColumnsRepository
	 */
	private $default_column_repository;

	/**
	 * @param DefaultColumnsRepository $default_column_repository
	 */
	public function __construct( DefaultColumnsRepository $default_column_repository ) {
		$this->default_column_repository = $default_column_repository;
	}

	private function get_default_columns( ListScreen $list_screen ) {
		$columns = [];

		foreach ( $this->default_column_repository->find_all( $list_screen->get_key() ) as $name => $label ) {
			if ( 'cb' === $name ) {
				continue;
			}

			$columns[ $name ] = ( new Column() )
				->set_original( true )
				->set_name( $name )
				->set_type( $name )
				->set_label( $label )
				->set_list_screen( $list_screen );
		}

		return $columns;
	}

	/**
	 * @param ListScreen $list_screen
	 *
	 * @return Column[]
	 */
	public function find( ListScreen $list_screen ) {
		// TODO: test
		$column_types = $this->get_default_columns( $list_screen );
		$column_types += $this->get_placeholders( $list_screen );
		$column_types += $list_screen->get_column_types();

		return $column_types;
	}

	/**
	 * @param ListScreen $list_screen
	 *
	 * @return Column\Placeholder[]
	 */
	private function get_placeholders( ListScreen $list_screen ) {
		$column_types = [];

		/** @var Integration $integration */
		foreach ( new Integrations() as $integration ) {

			if ( ! $integration->show_placeholder( $list_screen ) ) {
				continue;
			}

			$plugin_info = new PluginInformation( $integration->get_basename() );

			if ( $integration->is_plugin_active() && ! $plugin_info->is_active() ) {
				$column = ( new Column\Placeholder() )->set_integration( $integration );

				$column_types[ $column->get_type() ] = $column;
			}
		}

		return $column_types;
	}

}