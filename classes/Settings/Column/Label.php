<?php

namespace AC\Settings\Column;

use AC\Settings;
use AC\View;

class Label extends Settings\Column {

	const NAME = 'label';

	/**
	 * @var string
	 */
	private $label;

	public function __construct( $label ) {
		parent::__construct( self::NAME );

		$this->label = $label;
	}

	public function create_view( $column_name ) {

		$setting = $this
			->create_element( 'text', $column_name )
			->set_value( $this->label )
			->set_attribute( 'placeholder', $this->label );

		$view = new View( [
			'label'   => __( 'Label', 'codepress-admin-columns' ),
			'tooltip' => __( 'This is the name which will appear as the column header.', 'codepress-admin-columns' ),
			'setting' => $setting,
		] );

		$view->set_template( 'settings/setting-label' );

		return $view;
	}

	/**
	 * Convert site_url() to [cpac_site_url] and back for easy migration
	 *
	 * @param string $label
	 * @param string $action
	 *
	 * @return string
	 */
	private function convert_site_url( $label, $action = 'encode' ) {
		return ac_convert_site_url( $label, $action );
	}

	/**
	 * @return string
	 */
	public function get_label() {
		return $this->convert_site_url( $this->label, 'decode' );
	}

	/**
	 * @param string $label
	 */
	public function set_label( $label ) {
		$this->label = $label;
	}

	/**
	 * Encode label with site_url.
	 * Used when loading the setting from PHP or when a site is migrated to another domain.
	 * @return string
	 */
	public function get_encoded_label() {
		return $this->convert_site_url( $this->label );
	}

}