<?php

namespace AC\Column;

use AC\Column;
use AC\MetaType;

// TODO
abstract class Meta extends Column {

	/**
	 * @var MetaType
	 */
	protected $meta_type;

	public function __construct( $type, $name, MetaType $meta_type, array $data = [] ) {
		parent::__construct( $type, $name, $data );

		$this->meta_type = $meta_type;
	}

	/**
	 * @return string
	 */
	abstract public function get_meta_key();

	/**
	 * @param $id
	 *
	 * @return bool|mixed
	 * @see   Column::get_raw_value()
	 * @since 2.0.3
	 */
	public function get_raw_value( $id ) {
		return $this->get_meta_value( $id, $this->get_meta_key(), true );
	}

	/**
	 * @return MetaType
	 */
	public function get_meta_type() {
		return $this->meta_type;
	}

	/**
	 * @param int $id
	 * @param string $meta_key
	 * @param bool $single
	 *
	 * @return mixed
	 */
	public function get_meta_value( $id, $meta_key, $single = true ) {
		return get_metadata( $this->meta_type->get(), $id, $meta_key, $single );
	}

}