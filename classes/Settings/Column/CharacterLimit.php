<?php

namespace AC\Settings\Column;

use AC\Settings;
use AC\View;

class CharacterLimit extends Settings\Column
	implements Settings\FormatValue {

	const NAME = self::OPTION_LIMIT;
	const OPTION_LIMIT = 'character_limit';
	/**
	 * @var int
	 */
	private $limit;

	public function __construct( $limit ) {
		parent::__construct( self::NAME );

		$this->limit = $limit;
	}

	public function create_view( $column_name ) {
		$word_limit = $this->create_element( 'number', $column_name )
		                   ->set_attribute( 'min', 0 )
		                   ->set_attribute( 'step', 1 );

		$view = new View( [
			'label'   => __( 'Character Limit', 'codepress-admin-columns' ),
			'tooltip' => __( 'Maximum number of characters', 'codepress-admin-columns' ) . '<em>' . __( 'Leave empty for no limit', 'codepress-admin-columns' ) . '</em>',
			'setting' => $word_limit,
		] );

		return $view;
	}

	/**
	 * @return int
	 */
	public function get_character_limit() {
		return $this->limit;
	}

	/**
	 * @param int $character_limit
	 *
	 * @return bool
	 */
	// TODO remove
	public function set_character_limit( $character_limit ) {
		$this->limit = $character_limit;

		return true;
	}

	public function format( $value, $original_value ) {
		return ac_helper()->string->trim_characters( $value, $this->get_character_limit() );
	}

}