<?php

namespace AC\Settings\Column;

use AC\Settings;
use AC\View;

class Width extends Settings\Column
	implements Settings\Header {

	const NAME = self::OPTION_WIDTH;
	const OPTION_WIDTH = 'width';
	const OPTION_WIDTH_UNIT = 'width_unit';

	/**
	 * @var int
	 */
	private $width;

	/**
	 * @var string
	 */
	private $width_unit;

	public function __construct( $width, $width_unit = '%' ) {
		parent::__construct( self::NAME );

		if ( $width_unit !== '%' ) {
			$width_unit = 'px';
		}

		$this->width = (int) $width;
		$this->width_unit = $width_unit;
	}

	public function create_view( $column_name ) {
		$width = $this->create_element( 'text', $column_name, self::OPTION_WIDTH )
		              ->set_attribute( 'placeholder', __( 'Auto', 'codepress-admin-columns' ) )
		              ->set_value( $this->width > 0 ? $this->width : null );

		$unit = $this->create_element( 'radio', $column_name, self::OPTION_WIDTH_UNIT )
		             ->set_options( [
			             '%'  => '%',
			             'px' => 'px',
		             ] )
		             ->set_value( $this->width_unit );

		$section = new View( [
			'width' => $width,
			'unit'  => $unit,
		] );
		$section->set_template( 'settings/setting-width' );

		$view = new View( [
			'label'    => __( 'Width', 'codepress-admin-columns' ),
			'sections' => [ $section ],
		] );

		return $view;
	}

	public function create_header_view() {

		$view = new View( [
			'title'   => __( 'width', 'codepress-admin-columns' ),
			'content' => $this->get_display_width(),
		] );

		return $view;
	}

	/**
	 * @return int
	 */
	public function get_width() {
		return $this->width;
	}

	/**
	 * @return string
	 */
	public function get_width_unit() {
		return $this->width_unit;
	}

	public function get_display_width() {
		$value = '';

		if ( $this->width && $this->width_unit ) {
			$value = $this->width . $this->width_unit;
		}

		return $value;
	}

}