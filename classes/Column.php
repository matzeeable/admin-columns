<?php

namespace AC;

use AC\Settings\ColumnSettingsCollection;

/**
 * @since 3.0
 */
class Column extends LegacyColumn {

	// TODO formatters

	/**
	 * @var Settings\FormatValue[]|Settings\FormatCollection[]
	 */
	private $formatters;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var string
	 */
	protected $id;

	/**
	 * @var ColumnSettingsCollection|null
	 */
	protected $settings;

	public function __construct( $type, $id, ColumnSettingsCollection $settings = null ) {
		$this->type = $type;
		$this->id = $id;
		$this->settings = $settings;
	}

	public function get_type() {
		return $this->type;
	}

	public function has_settings() {
		return null !== $this->settings;
	}

	public function get_settings() {
		return $this->settings;
	}

	public function get_setting( $name ) {
		return $this->settings->offsetExists( $name )
			? $this->settings->offsetGet( $name )
			: null;
	}



	// ###################
	// ###################
	// ###################
	// TODO
	// ###################
	// ###################
	// ###################

	public function get_formatters() {
		if ( null === $this->formatters ) {

			// TODO
			foreach ( $this->settings as $setting ) {
				if ( $setting instanceof Settings\FormatValue || $setting instanceof Settings\FormatCollection ) {
					$this->formatters[] = $setting;
				}
			}
		}

		return $this->formatters;
	}

	/**
	 * Apply available formatters (recursive) on the value
	 *
	 * @param mixed $value
	 * @param mixed $original_value
	 * @param int $current Current index of self::$formatters
	 *
	 * @return mixed
	 */

	// TODO: DI Renderable with formatting
	public function get_formatted_value( $value, $original_value = null, $current = 0 ) {
		$formatters = $this->get_formatters();
		$available = count( (array) $formatters );

		if ( null === $original_value ) {
			$original_value = $value;
		}

		if ( $available > $current ) {
			$is_collection = $value instanceof Collection;
			$is_value_formatter = $formatters[ $current ] instanceof Settings\FormatValue;

			if ( $is_collection && $is_value_formatter ) {
				foreach ( $value as $k => $v ) {
					$value->put( $k, $this->get_formatted_value( $v, null, $current ) );
				}

				while ( $available > $current ) {
					if ( $formatters[ $current ] instanceof Settings\FormatCollection ) {
						return $this->get_formatted_value( $value, $original_value, $current );
					}

					++ $current;
				}
			} elseif ( ( $is_collection && ! $is_value_formatter ) || $is_value_formatter ) {
				$value = $formatters[ $current ]->format( $value, $original_value );

				return $this->get_formatted_value( $value, $original_value, ++ $current );
			}
		}

		return $value;
	}

	/**
	 * Display value
	 *
	 * @param int $id
	 *
	 * @return string
	 */
	public function get_value( $id ) {
		$value = $this->get_formatted_value( $this->get_raw_value( $id ), $id );

		if ( $value instanceof Collection ) {
			$value = $value->filter()->implode( $this->get_separator() );
		}

		return (string) $value;
	}

	/**
	 * @return string
	 */
	public function get_separator() {
		return ', ';
	}

	/**
	 * @return string
	 */
	public function get_empty_char() {
		return '&ndash;';
	}

}