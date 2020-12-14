<?php

namespace AC\Settings;

use AC;
use AC\Form\Element;
use AC\View;

abstract class Column {

	/**
	 * @var string
	 */
	protected $column_name;

	/**
	 * A (short) reference to this setting
	 * @var string
	 */
	protected $name;

	/**
	 * The options this field manages (optionally with default values)
	 * @var array
	 */
	protected $options = [];

	public function __construct( $name ) {
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * Create a string representation of this setting
	 *
	 * @param string $column_name
	 *
	 * @return View|false
	 */
	protected abstract function create_view( $column_name );

	/**
	 * Get settings that depend on this setting
	 * @return Column[]
	 */
	public function get_dependent_settings() {
		return [];
	}

	public function has_option( $option ) {
		return array_key_exists( $option, $this->options );
	}

	/**
	 * Add an element to this setting
	 *
	 * @param string $type
	 * @param string|null $name
	 *
	 * @return Element\Select|Element\Input|Element\Radio
	 */
	protected function create_element( $type, $column_name, $name = null ) {
		if ( null === $name ) {
			$name = $this->name;
		}

		switch ( $type ) {

			case 'checkbox' :
				$element = new Element\Checkbox( $name );

				break;
			case 'radio' :
				$element = new Element\Radio( $name );

				break;
			case 'select' :
				$element = new AC\Settings\Form\Element\Select( $name );

				break;
			default:
				$element = new Element\Input( $name );
				$element->set_type( $type );
		}

		$element->set_name( sprintf( 'columns[%s][%s]', $column_name, $name ) );
		$element->set_id( sprintf( 'ac-%s-%s', $column_name, $name ) );
		$element->add_class( 'ac-setting-input_' . $name );

		return $element;
	}

	/**
	 * Render the output of self::create_header()
	 * @return false|string
	 */
	public function render_header() {
		if ( ! ( $this instanceof Header ) ) {
			return false;
		}

		/* @var Header $this */
		$view = $this->create_header_view();

		if ( ! ( $view instanceof View ) ) {
			return false;
		}

		if ( null == $view->get_template() ) {
			$view->set_template( 'settings/header' );
		}

		if ( null == $view->setting ) {
			$view->set( 'setting', $this->name );
		}

		return $view->render();
	}

	/**
	 * Render the output of self::create_view()
	 *
	 * @param string $column_name
	 *
	 * @return false|string
	 */
	public function render( $column_name ) {
		$view = $this->create_view( $column_name );

		if ( ! ( $view instanceof View ) ) {
			return false;
		}

		$template = 'settings/section';

		// set default template
		if ( null === $view->get_template() ) {
			$view->set_template( $template );
		}

		// set default name
		if ( null === $view->get( 'name' ) ) {
			$view->set( 'name', $this->name );
		}

		// set default for
		if ( null === $view->get( 'for' ) ) {
			$setting = $view->get( 'setting' );

			if ( $setting instanceof AC\Form\Element ) {
				$view->set( 'for', $setting->get_id() );
			}
		}

		// set default template for nested sections
		foreach ( (array) $view->sections as $section ) {
			if ( $section instanceof View && null === $section->get_template() ) {
				$section->set_template( $template );
			}
		}

		return $view->render();
	}

	public function get_value() {
		return call_user_func( [ $this, 'get_' . $this->name ] );
	}

}