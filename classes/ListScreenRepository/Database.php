<?php

namespace AC\ListScreenRepository;

use AC\ColumnFactory;
use AC\Exception\MissingListScreenIdException;
use AC\ListScreen;
use AC\ListScreenCollection;
use AC\ListScreenFactoryInterface;
use AC\ListScreenRepositoryWritable;
use AC\Type\ListScreenId;
use DateTime;
use LogicException;

final class Database implements ListScreenRepositoryWritable {

	const TABLE = 'admin_columns';

	/**
	 * @var ListScreenFactoryInterface
	 */
	private $list_screen_factory;

	/**
	 * @var ColumnFactory
	 */
	private $column_factory;

	public function __construct(
		ListScreenFactoryInterface $list_screen_factory,
		ColumnFactory $column_factory
	) {
		$this->list_screen_factory = $list_screen_factory;
		$this->column_factory = $column_factory;
	}

	/**
	 * @param array $args
	 *
	 * @return array
	 */
	private function find_all_from_database( array $args = [] ) {
		global $wpdb;

		$args = array_merge( [
			self::KEY => null,
		], $args );

		$sql = '
			SELECT * 
			FROM ' . $wpdb->prefix . self::TABLE . '
			WHERE 1=1
		';

		$where = [];

		if ( $args[ self::KEY ] ) {
			$where[] = $wpdb->prepare( 'AND list_key = %s', $args[ self::KEY ] );
		}

		$sql .= implode( "\n", $where );

		return $wpdb->get_results( $sql );
	}

	/**
	 * @param array $args
	 *
	 * @return ListScreenCollection
	 */
	public function find_all( array $args = [] ) {
		$list_screens = new ListScreenCollection();

		foreach ( $this->find_all_from_database( $args ) as $list_data ) {
			$list_screen = $this->create_list_screen( $list_data );

			if ( $list_screen instanceof ListScreen ) {
				$list_screens->add( $list_screen );
			}
		}

		return $list_screens;
	}

	/**
	 * @param ListScreenId $id
	 *
	 * @return object|null
	 */
	private function find_from_database( ListScreenId $id ) {
		global $wpdb;

		$sql = '
			SELECT *
			FROM ' . $wpdb->prefix . self::TABLE . '
			WHERE list_id = %s
			LIMIT 1;
		';

		$data = $wpdb->get_row( $wpdb->prepare( $sql, $id->get_id() ) );

		if ( ! isset( $data->list_id ) ) {
			return null;
		}

		return $data;
	}

	/**
	 * @param ListScreenId $id
	 *
	 * @return ListScreen|null
	 */
	public function find( ListScreenId $id ) {
		$data = $this->find_from_database( $id );

		if ( ! $data ) {
			return null;
		}

		return $this->create_list_screen( $data );
	}

	/**
	 * @param ListScreenId $list_screen_id
	 *
	 * @return bool
	 */
	public function exists( ListScreenId $list_screen_id ) {
		return null !== $this->find_from_database( $list_screen_id );
	}

	/**
	 * @param ListScreen $list_screen
	 *
	 * @return void
	 */
	// TODO: maybe accept <object> $data instead of ListScreen
	public function save( ListScreen $list_screen ) {
		global $wpdb;

		if ( ! $list_screen->has_id() ) {
			throw MissingListScreenIdException::from_saving_list_screen();
		}

		$columns = [];

		if ( $list_screen->has_columns() ) {
			foreach ( $list_screen->get_columns() as $column ) {
				$columns[] = $column->get_options();
			}
		}

		$args = [
			'list_id'       => $list_screen->get_id()->get_id(),
			'list_key'      => $list_screen->get_key(),
			'title'         => $list_screen->get_title(),
			'columns'       => $columns ? serialize( $columns ) : null,
			'settings'      => $list_screen->get_preferences() ? serialize( $list_screen->get_preferences() ) : null,
			'date_modified' => $list_screen->get_updated()->format( 'Y-m-d H:i:s' ),
		];

		$table = $wpdb->prefix . self::TABLE;
		$stored = $this->find_from_database( $list_screen->get_id() );

		if ( $stored ) {
			$wpdb->update(
				$table,
				$args,
				[
					'id' => $stored->id,
				],
				array_fill( 0, 6, '%s' ),
				[
					'%d',
				]
			);
		} else {
			$args['date_created'] = $args['date_modified'];

			$wpdb->insert(
				$table,
				$args,
				array_fill( 0, 7, '%s' )
			);
		}
	}

	public function delete( ListScreen $list_screen ) {
		global $wpdb;

		if ( ! $list_screen->has_id() ) {
			throw new LogicException( 'Cannot delete a ListScreen without an identity.' );
		}

		/**
		 * Fires before a column setup is removed from the database
		 * Primarily used when columns are deleted through the Admin Columns settings screen
		 *
		 * @param ListScreen $list_screen
		 *
		 * @deprecated 4.0
		 * @since      3.0.8
		 */
		do_action( 'ac/columns_delete', $list_screen );

		$wpdb->delete(
			$wpdb->prefix . self::TABLE,
			[
				'list_id' => $list_screen->get_id()->get_id(),
			],
			[
				'%s',
			]
		);
	}

	/**
	 * @param object $data
	 *
	 * @return ListScreen
	 */
	private function create_list_screen( $data ) {
		$list_screen = $this->list_screen_factory->create( $data->list_key );

		if ( ! $list_screen ) {
			return null;
		}

		$list_screen->set_id( new ListScreenId( $data->list_id ) );
		$list_screen->set_updated( DateTime::createFromFormat( 'Y-m-d H:i:s', $data->date_modified ) );

		$settings = $data->settings
			? unserialize( $data->settings )
			: [];

		$settings['title'] = $data->title;

		$list_screen->set_preferences( $settings );

		if ( $data->columns ) {
			foreach ( unserialize( $data->columns ) as $column_name => $column_data ) {
				$column = $this->column_factory->create( $column_data + [ 'name' => $column_name ], $list_screen );

				if ( null === $column ) {
					continue;
				}

				$list_screen->add_column( $column );
			}
		}

		return $list_screen;
	}

}