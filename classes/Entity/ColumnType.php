<?php

namespace AC\Entity;

class ColumnType {

	/**
	 * @var string
	 */
	private $key;

	/**
	 * @var string
	 */
	private $label;
	/**
	 * @var string
	 */
	private $list_key;

	/**
	 * @var string|null
	 */
	private $group;

	public function __construct( $key, $label, $list_key, $group = null ) {
		$this->key = $key;
		$this->label = $label;
		$this->list_key = $list_key;
		$this->group = $group;
	}

	/**
	 * @return string
	 */
	public function get_key() {
		return $this->key;
	}

	/**
	 * @return string
	 */
	public function get_label() {
		return $this->label;
	}

	/**
	 * @return string
	 */
	public function get_list_key() {
		return $this->list_key;
	}

	/**
	 * @return bool
	 */
	public function has_group() {
		return null !== $this->group;
	}

	/**
	 * @return string
	 */
	public function get_group() {
		return $this->group;
	}

}