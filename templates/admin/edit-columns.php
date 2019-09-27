<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @global array        $notices
 * @global string       $class
 * @global string       $list_screen
 * @global \AC\Column[] $columns
 * @global bool         $show_actions
 * @global bool         $show_clear_all
 */

echo implode( $this->notices ); ?>

<div class="ac-boxes <?php echo esc_attr( $this->class ); ?>">
	<form method="post" id="listscreen_settings">
		<div class="ac-columns">

			<input type="hidden" name="list_screen" value="<?= esc_attr( $this->list_screen ); ?>"/>
			<input type="hidden" name="title" value="<?= esc_attr( $this->title ); ?>">
			<input type="hidden" name="settings[]" value="">
			<input type="hidden" name="list_screen_id" value="<?= esc_attr( $this->list_screen_id ); ?>">

			<?php wp_nonce_field( 'update-type', '_ac_nonce', false ); ?>

			<?php
			foreach ( $this->columns as $column ) {
				$view = new \AC\View( array(
					'column' => $column,
				) );

				echo $view->set_template( 'admin/edit-column' );
			}
			?>
		</div>

		<div class="column-footer">

			<?php if ( $this->show_actions ) : ?>

				<div class="button-container">

					<?php if ( $this->show_clear_all ) : ?>
						<a class="clear-columns" data-clear-columns><?php _e( 'Clear all columns ', 'codepress-admin-columns' ) ?></a>
					<?php endif; ?>

					<span class="spinner"></span>
					<a class="button-primary submit update"><?php _e( 'Update' ); ?></a>
					<a class="button-primary submit save"><?php _e( 'Save' ); ?></a>
					<a class="add_column button">+ <?php _e( 'Add Column', 'codepress-admin-columns' ); ?></a>
				</div>

			<?php endif; ?>

		</div>
	</form>

</div>