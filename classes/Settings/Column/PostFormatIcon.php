<?php

namespace AC\Settings\Column;

use AC\Settings;
use AC\View;

class PostFormatIcon extends Settings\Column
	implements Settings\FormatValue {

	const NAME = 'use_icon';

	/**
	 * @var bool
	 */
	private $use_icon;

	public function __construct( $use_icon = true ) {
		parent::__construct( self::NAME );

		$this->use_icon = (bool) $use_icon;
	}

	public function create_view( $column_name ) {

		$setting = $this->create_element( 'radio', $column_name )
		                ->set_options( [
			                '1' => __( 'Yes' ),
			                ''  => __( 'No' ),
		                ] )->set_value( $this->use_icon );

		return new View( [
			'label'   => __( 'Use an icon?', 'codepress-admin-columns' ),
			'tooltip' => __( 'Use an icon instead of text for displaying.', 'codepress-admin-columns' ),
			'setting' => $setting,
		] );
	}

	/**
	 * @return bool
	 */
	public function get_use_icon() {
		return $this->use_icon;
	}

	private function use_icon() {
		return '1' === $this->get_use_icon();
	}

	/**
	 * @param     $format
	 * @param int $post_id
	 *
	 * @return string
	 */
	public function format( $format, $post_id ) {

		if ( $this->use_icon() ) {

			// TODO: use empty char
			$value = null;

			if ( $format ) {
				$value = ac_helper()->html->tooltip( '<span class="ac-post-state-format post-state-format post-format-icon post-format-' . esc_attr( $format ) . '"></span>', get_post_format_string( $format ) );
			}
		} else {
			$value = __( 'Standard', 'codepress-admin-columns' );

			if ( $format ) {
				$value = esc_html( get_post_format_string( $format ) );
			}
		}

		return $value;
	}

}