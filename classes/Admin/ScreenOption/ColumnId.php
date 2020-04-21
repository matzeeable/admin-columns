<?php

namespace AC\Admin\ScreenOption;

use AC\Admin\Preference;
use AC\Admin\ScreenOption;
use AC\Preferences;

class ColumnId extends ScreenOption {

	const NAME = 'screen_options';
	const VALUE = 'show_column_id';

	/**
	 * @var Preferences\User
	 */
	private $preference;

	public function __construct( Preference\ScreenOptions $preference ) {
		$this->preference = $preference;
	}

	private function is_active() {
		return 1 === $this->preference->get( self::NAME );
	}

	public function render() {
		ob_start();
		?>
		<label for="ac-column-id" data-ac-screen-option="<?= self::NAME; ?>">
			<input id="ac-column-id" type="checkbox" value="1" name="<?= self::NAME; ?>"<?php checked( $this->is_active() ); ?>>
			<?= __( 'Column ID', 'codepress-admin-columns' ); ?>
		</label>
		<?php
		return ob_get_clean();
	}

}