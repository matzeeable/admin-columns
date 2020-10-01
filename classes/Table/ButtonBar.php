<?php

namespace AC\Table;

use AC;

final class ButtonBar implements AC\Renderable {

	/**
	 * @var Button[]
	 */
	private $buttons;

	public function add_button( Button $button, $priority = 10 ) {
		$this->buttons[ $priority ][] = $button;

		ksort( $this->buttons, SORT_NUMERIC );
	}

	public function render() {
		$buttons = array_merge( [], ...$this->buttons );

		if ( ! $buttons ) {
			return;
		}
		?>
        <div class="ac-table-actions-buttons">
			<?php foreach ( $buttons as $button ) : ?>
				<?php $button->render(); ?>
			<?php endforeach; ?>
        </div>
		<?php
	}

}