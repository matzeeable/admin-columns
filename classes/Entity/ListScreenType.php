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
	 * @var string
	 */
	private $url;

	/**
	 * @var bool
	 */
	private $network;

	// TODO: add meta type?

	/**
	 * @param string $key
	 * @param string $label
	 * @param string $group
	 * @param bool $network
	 */
	public function __construct( $key, $label, $group, $url, $network = false ) {
		$this->key = $key;
		$this->label = $label;
		$this->group = $group;
		$this->url = $url;
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
	 * @return string
	 */
	public function get_url() {
		return $this->url;
	}

	/**
	 * @return bool
	 */
	public function is_network() {
		return $this->network;
	}

}