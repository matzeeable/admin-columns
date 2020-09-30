<?php

namespace AC\ListScreenRepository;

use AC\ListScreen;
use AC\ListScreenCollection;
use AC\ListScreenRepository;
use AC\ListScreenRepositoryWritable;
use AC\Type\ListScreenData;
use AC\Type\ListScreenId;
use LogicException;

final class Storage implements ListScreenRepositoryWritable {

	/**
	 * @var Storage\ListScreenRepository[]
	 */
	private $repositories = [];

	/**
	 * @return Storage\ListScreenRepository[]
	 */
	public function get_repositories() {
		return array_reverse( $this->repositories );
	}

	public function set_repositories( array $repositories ) {
		foreach ( $repositories as $repository ) {
			if ( ! $repository instanceof ListScreenRepository\Storage\ListScreenRepository ) {
				throw new LogicException( 'Expected a Storage\ListScreenRepository object.' );
			}
		}

		$this->repositories = array_reverse( $repositories );
	}

	public function has_repository( $key ) {
		return array_key_exists( $key, $this->repositories );
	}

	public function get_repository( $key ) {
		if ( ! $this->has_repository( $key ) ) {
			throw new LogicException( sprintf( 'Repository with key %s not found.', $key ) );
		}

		return $this->repositories[ $key ];
	}

	/**
	 * @param array $args
	 *
	 * @return ListScreenCollection
	 */
	public function find_all( array $args = [] ) {
		$args = array_merge( [
			'filter' => null,
			'sort'   => null,
		], $args );

		$list_screens = new ListScreenCollection();

		foreach ( $this->repositories as $repository ) {
			foreach ( $repository->find_all( $args ) as $list_screen ) {
				if ( ! $list_screens->contains( $list_screen ) ) {
					$list_screens->add( $list_screen );
				}
			}
		}

		if ( $args['filter'] instanceof Filter ) {
			$list_screens = $args['filter']->filter( $list_screens );
		}

		if ( $args['sort'] instanceof Sort ) {
			$list_screens = $args['sort']->sort( $list_screens );
		}

		return $list_screens;
	}

	/**
	 * @param ListScreenId $id
	 *
	 * @return ListScreen|null
	 */
	public function find( ListScreenId $id ) {
		foreach ( $this->repositories as $repository ) {
			if ( ! $repository->exists( $id ) ) {
				continue;
			}

			$list_screen = $repository->find( $id );

			if ( ! $list_screen ) {
				continue;
			}

			return $list_screen;
		}

		return null;
	}

	/**
	 * @param ListScreenId $id
	 *
	 * @return bool
	 */
	public function exists( ListScreenId $id ) {
		return null !== $this->find( $id );
	}

	/**
	 * @param ListScreenData $data
	 *
	 * @return ListScreen|null
	 */
	public function save( ListScreenData $data ) {
		foreach ( $this->repositories as $repository ) {
			if ( ! $this->is_writable( $repository, $data->get( ListScreenData::PARAM_ID ), $data->get( ListScreenData::PARAM_KEY ) ) ) {
				continue;
			}

			// TODO: repo should return a initiated ListScreen
			$repository->save( $data );
		}

		return $this->find( new ListScreenId( $data->get( 'id' ) ) );
	}

	private function is_writable( ListScreenRepository $repository, $list_id, $list_key, $list_group = null  ) {
		$match = true;

		if ( $repository->has_rules() ) {
			$match = $repository->get_rules()->match( [
				Rule::ID    => $list_id ? new ListScreenId( $list_id ) : null,
				Rule::TYPE  => $list_key,
				// TODO
				Rule::GROUP => $list_group,
			] );
		}

		return $match && $repository->is_writable();
	}

	public function delete( ListScreen $list_screen ) {
		foreach ( $this->repositories as $repository ) {
			if ( ! $this->is_writable( $repository, $list_screen->get_id()->get_id(), $list_screen->get_key() ) ) {
				continue;
			}

			$repository->delete( $list_screen );
		}
	}

	// TODO: remove
	/**
	 * @param ListScreenData $data
	 * @param $action
	 *
	 * @return ListScreen|null
	 */
//	private function update( ListScreenData $data, $action ) {
//		foreach ( $this->repositories as $repository ) {
//			$match = true;
//
//			if ( $repository->has_rules() ) {
//				$match = $repository->get_rules()->match( [
//					Rule::ID    => $data->has( 'id' ) ? $data->get( 'id' ) : null,
//					Rule::TYPE  => $data->get( 'key' ),
//					// TODO
//					Rule::GROUP => '', //$list_screen->get_group(),
//				] );
//			}
//
//			if ( $match && $repository->is_writable() ) {
//				switch ( $action ) {
//					case 'save':
//						$repository->save( $data );
//
//						return $this->find( $data->get( 'id' ) );
//					case 'delete':
//						$repository->delete( $this->find( $data->get( 'id' ) ) );
//
//						break;
//					default:
//						throw new LogicException( 'Invalid action for update call.' );
//				}
//
//				return null;
//			}
//		}
//	}

}