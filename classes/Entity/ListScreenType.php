<?php

namespace AC\Entity;

class ListScreenType {

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
	private $group;

	/**
	 * @var bool
	 */
	private $network;

	/**
	 * @param string $key
	 * @param string $label
	 * @param string $group
	 * @param bool $network
	 */
	public function __construct( $key, $label, $group, $network = false ) {
		$this->key = $key;
		$this->label = $label;
		$this->group = $group;
		$this->network = (bool) $network;
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
	public function get_group() {
		return $this->group;
	}

	/**
	 * @return bool
	 */
	public function is_network() {
		return $this->network;
	}

}