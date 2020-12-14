<?php

namespace AC\Settings\Column;

use AC\Settings;
use AC\View;

class AttachmentDisplay extends Settings\Column
	implements Settings\FormatValue {

	const NAME = 'attachment_display';
	const OPTION_THUMBNAIL = 'thumbnail';
	const OPTION_COUNT = 'count';

	private $attachment_display;

	public function __construct( $display = null ) {
		parent::__construct( self::NAME );

		if ( null === $display ) {
			$display = self::OPTION_THUMBNAIL;
		}

		$this->attachment_display = $display;
	}

	public function get_dependent_settings() {
		$settings = [];

		switch ( $this->attachment_display ) {
			case self::OPTION_THUMBNAIL :

				// TODO
				$settings[] = new Settings\Column\Images();

				break;
		}

		return $settings;
	}

	public function create_view( $column_name ) {

		$setting = $this->create_element( 'select', $column_name )
		                ->set_attribute( 'data-refresh', 'column' )
		                ->set_options( [
			                self::OPTION_THUMBNAIL => __( 'Thumbnails', 'codepress-admin-columns' ),
			                self::OPTION_COUNT     => __( 'Count', 'codepress-admin-columns' ),
		                ] )
		                ->set_value( $this->attachment_display );

		return new View( [
			'label'   => __( 'Display', 'codepress-admin-columns' ),
			'setting' => $setting,
		] );
	}

	/**
	 * @return int
	 */
	public function get_attachment_display() {
		return $this->attachment_display;
	}

	/**
	 * @param int $attachment_display
	 *
	 * @return bool
	 */
	public function set_attachment_display( $attachment_display ) {
		$this->attachment_display = $attachment_display;

		return true;
	}

	public function format( $value, $original_value ) {
		switch ( $this->get_attachment_display() ) {
			case 'count':
				$value = count( $value );
				break;
		}

		return $value;
	}
}