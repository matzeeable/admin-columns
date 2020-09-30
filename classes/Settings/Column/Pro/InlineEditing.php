<?php

namespace AC\Settings\Column\Pro;

use AC\Settings;
use AC\View;

class InlineEditing extends Settings\Column\Pro {

	protected function get_label() {
		return __( 'Inline Editing', 'codepress-admin-columns' );
	}

	protected function get_instructions() {
		$view = new View( [
			// TODO
			'object_type' => '', //$this->column->get_list_screen()->get_label()->get_single(),
		] );

		return $view->set_template( 'tooltip/inline-editing' );
	}

	protected function define_options() {
		return [ 'inline-edit' ];
	}

}