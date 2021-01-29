<?php

namespace AC\Settings\Column;

use AC\Settings;
use AC\View;

class AttachmentDisplay extends Settings\Column
	implements Settings\FormatValue {

	const NAME = 'attachment_display';
	const OPTION_THUMBNAIL = 'thumbnail';
	const OPTION_COUNT = 'count';

	/**
	 * @var string
	 */
	private $attachment_display;

	/**
	 * @var Settings\ColumnSettingsCollection|null
	 */
	private $settings;

	public function __construct( $display = null, Settings\ColumnSettingsCollection $settings = null ) {
		parent::__construct( self::NAME );

		if ( null === $display ) {
			$display = self::OPTION_THUMBNAIL;
		}

		$this->attachment_display = $display;
		$this->settings = $settings;
	}

	/**
	 * @return Settings\ColumnSettingsCollection|null
	 */
	public function get_settings() {
		return $this->settings;
	}



//	public function get_dependent_settings() {
//		$settings = [];
//
//		switch ( $this->attachment_display ) {
//			case self::OPTION_THUMBNAIL :
//
//				// TODO how to handle dependent settings
//				$settings[] = new Settings\Column\Images();
//
//				break;
//		}
//
//		return $settings;
//	}

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
	 * @return string
	 */
	public function get_attachment_display() {
		return $this->attachment_display;
	}

	// TODO inject formatter
	public function format( $value, $original_value ) {
		switch ( $this->get_attachment_display() ) {
			case self::OPTION_COUNT:
				$value = count( $value );
				break;
		}

		return $value;
	}
}