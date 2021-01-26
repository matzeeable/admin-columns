<?php

namespace AC\Settings\Column;

use AC\Settings;
use AC\View;

class WordLimit extends Settings\Column
	implements Settings\FormatValue {

	const NAME = 'word_limit';
	const OPTION_LIMIT = 'excerpt_length';

	/**
	 * @var int
	 */
	private $excerpt_length;

	public function __construct( $excerpt_length ) {
		parent::__construct( self::NAME );

		$this->excerpt_length = $excerpt_length;
	}

	public function create_view( $column_name ) {
		$setting = $this->create_element( 'number', $column_name )
		                ->set_attributes( [
			                'min'  => 0,
			                'step' => 1,
		                ] );

		$view = new View( [
			'label'   => __( 'Word Limit', 'codepress-admin-columns' ),
			'tooltip' => __( 'Maximum number of words', 'codepress-admin-columns' ) . '<em>' . __( 'Leave empty for no limit', 'codepress-admin-columns' ) . '</em>',
			'setting' => $setting,
		] );

		return $view;
	}

	/**
	 * @return int
	 */
	public function get_excerpt_length() {
		return $this->excerpt_length;
	}

	public function format( $value, $original_value ) {
		$values = [];

		foreach ( (array) $value as $_string ) {
			$values[] = ac_helper()->string->trim_words( $_string, $this->get_excerpt_length() );
		}

		return ac_helper()->html->implode( $values );
	}

}