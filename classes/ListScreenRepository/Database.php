<?php

namespace AC\ListScreenRepository;

use AC\Exception\MissingListScreenIdException;
use AC\ListScreen;
use AC\ListScreenCollection;
use AC\ListScreenFactoryInterface;
use AC\ListScreenRepositoryWritable;
use AC\Type\ListScreenData;
use AC\Type\ListScreenId;
use DateTime;
use LogicException;

final class Database implements ListScreenRepositoryWritable {

	const TABLE = 'admin_columns';

	/**
	 * @var ListScreenFactoryInterface
	 */
	private $list_screen_factory;

	public function __construct( ListScreenFactoryInterface $list_screen_factory ) {
		$this->list_screen_factory = $list_screen_factory;
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
	 * @param ListScreenData $list_screen
	 *
	 * @return ListScreen
	 */
	public function save( ListScreenData $data ) {
		global $wpdb;

		if ( ! ListScreenId::is_valid_id( $data->get( 'id' ) ) ) {
			throw MissingListScreenIdException::from_saving_list_screen();
		}

		$args = [
			'list_id'       => $data->get( 'id' ),
			'list_key'      => $data->get( 'key' ),
			'title'         => $data->get( 'title' ),
			'columns'       => $data->has( 'columns' ) ? serialize( $data->get( 'columns' ) ) : null,
			'settings'      => $data->has( 'settings' ) ? serialize( $data->get( 'settings' ) ) : null,
			'date_modified' => $data->has( 'date' ) ? $data->get( 'date' ) : ( new DateTime() )->format( 'Y-m-d H:i:s' ),
		];

		$table = $wpdb->prefix . self::TABLE;
		$stored = $this->find_from_database( new ListScreenId( $data->get( 'id' ) ) );

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
	private function create_list_screen( $row ) {
		$data = [
			'key'  => $row->list_key,
			'id'   => $row->list_id,
			'date' => DateTime::createFromFormat( 'Y-m-d H:i:s', $row->date_modified ),
		];

		if ( $row->settings ) {
			$data['settings'] = unserialize( $row->settings );
		}

		if ( $row->title ) {
			$data['settings']['title'] = $row->title;
		}

		if ( $row->columns ) {
			$data['columns'] = unserialize( $row->columns );
		}

		return $this->list_screen_factory->create( new ListScreenData( $data ) );
	}

}