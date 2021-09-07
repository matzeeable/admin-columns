<?php

namespace AC\Admin\Notice;

use AC\ListScreen;
use AC\Message;
use AC\Registrable;

class DefaultColumns implements Registrable {

	public function register() {
		add_action( 'ac/settings/notice', [ $this, 'render_notice' ] );

	}

	public function render_notice( ListScreen $list_screen ) {
		if ( empty( $list_screen->get_settings() ) ) {
			$message = __( 'Columns not stored yet. The default WordPress columns are loaded.', 'codepress-admin-columns' );
			$message .= '<br>' . __( 'Save your settings on the right or <a href="" data-clear-columns>clear columns</a> to start fresh.', 'codepress-admin-columns' );
			$message = sprintf( '<p>%s</p>', $message );

			$notice = new Message\InlineMessage( $message );

			echo $notice->set_type( Message::INFO )
			            ->render();
		}
	}

}