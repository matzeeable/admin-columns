<?php

namespace AC\Plugin;

interface StoredVersion {

	/**
	 * @param string $version
	 *
	 * @return string
	 */
	public function update( $version );

	/**
	 * @return string
	 */
	public function get();

	/**
	 * @return bool
	 */
	public function exists();

}