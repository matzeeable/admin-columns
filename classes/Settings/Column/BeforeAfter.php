<?php

namespace AC\Settings\Column;

use AC\Settings;
use AC\Settings\Column;
use AC\View;

class BeforeAfter extends Column
	implements Settings\FormatValue {

	const NAME = 'before_after';
	const OPTION_BEFORE = 'before';
	const OPTION_AFTER = 'after';

	/**
	 * @var string
	 */
	private $before;

	/**
	 * @var string
	 */
	private $after;

	/**
	 * @var array
	 */
	private $placeholders;

	public function __construct( $before, $after, array $placeholders = [] ) {
		parent::__construct( self::NAME );

		$this->before = (string) $before;
		$this->after = (string) $after;
		$this->placeholders = $placeholders;
	}

	// TODO remove
//	protected function set_name() {
//		$this->name = self::NAME;
//	}
//
//	protected function define_options() {
//		return [ 'before', 'after' ];
//	}

	public function format( $value, $original_value ) {
		if ( ac_helper()->string->is_empty( $value ) ) {
			return $value;
		}

		if ( $this->before || $this->after ) {
			$value = $this->before . $value . $this->after;
		}

		return $value;
	}

	private function get_placeholder( $name ) {
		return isset( $this->placeholders[ $name ] )
			? $this->placeholders[ $name ]
			: null;
	}

	protected function get_before_element( $column_name ) {
		$text = $this->create_element( 'text', $column_name, self::OPTION_BEFORE )->set_value( $this->before );
		$text->set_attribute( 'placeholder', $this->get_placeholder( 'before' ) );

		return $text;
	}

	protected function get_after_element( $column_name ) {
		$text = $this->create_element( 'text', $column_name, self::OPTION_AFTER )->set_value( $this->after );
		$text->set_attribute( 'placeholder', $this->get_placeholder( 'after' ) );

		return $text;
	}

	public function create_view( $column_name ) {
		$setting = $this->get_before_element( $column_name );

		$for = $setting->get_id();

		$before = new View( [
			'label'       => __( 'Before', 'codepress-admin-columns' ),
			'description' => __( 'This text will appear before the column value.', 'codepress-admin-columns' ),
			'setting'     => $setting,
			'for'         => $for,
		] );

		$setting = $this->get_after_element( $column_name );

		$after = new View( [
			'label'       => __( 'After', 'codepress-admin-columns' ),
			'description' => __( 'This text will appear after the column value.', 'codepress-admin-columns' ),
			'setting'     => $setting,
			'for'         => $setting->get_id(),
		] );

		return new View( [
			'label'    => __( 'Display Options', 'codepress-admin-columns' ),
			'sections' => [ $before, $after ],
			'for'      => $for,
		] );
	}

	/**
	 * @return string
	 */
	public function get_before() {
		return $this->before;
	}

	/**
	 * @return string
	 */
	public function get_after() {
		return $this->after;
	}

}