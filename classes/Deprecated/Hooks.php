<?php

namespace AC\Deprecated;

use AC\ColumnTypesRepository;
use AC\Deprecated\Hook\Action;
use AC\Deprecated\Hook\Filter;
use AC\ListScreenFactory;
use AC\ListScreenTypeRepository;
use AC\Registrable;
use AC\Type\ListScreenData;

class Hooks implements Registrable {

	/**
	 * @var ListScreenTypeRepository
	 */
	private $list_screen_type_repository;

	/**
	 * @var ListScreenFactory
	 */
	private $list_screen_factory;

	/**
	 * @var ColumnTypesRepository
	 */
	private $column_types_repository;

	/**
	 * @var HookCount
	 */
	private $hook_count;

	public function __construct(
		ListScreenTypeRepository $list_screen_type_repository,
		ListScreenFactory $list_screen_factory,
		ColumnTypesRepository $column_types_repository
	) {
		$this->list_screen_type_repository = $list_screen_type_repository;
		$this->list_screen_factory = $list_screen_factory;
		$this->column_types_repository = $column_types_repository;
		$this->hook_count = new HookCount();
	}

	public function register() {
		add_action( 'init', [ $this, 'update_count' ] );
	}

	public function update_count( $force = false ) {
		if ( $this->hook_count->is_expired() || $force ) {
			$this->hook_count->save( $this->get_deprecated_count(), WEEK_IN_SECONDS );
		}
	}

	/**
	 * @return int
	 */
	public function get_count() {
		return $this->hook_count->get();
	}

	/**
	 * @return Filter[]
	 */
	private function get_filters() {
		$hooks = [
			new Filter( 'cac/headings/label', '3.0', 'cac-columns-custom' ),
			new Filter( 'cac/column/meta/value', '3.0', 'cac-column-meta-value' ),
			new Filter( 'cac/column/meta/types', '3.0', 'cac-column-meta-types' ),
			new Filter( 'cac/settings/tabs', '3.0', 'cac-settings-tabs' ),
			new Filter( 'cac/editable/is_column_editable', '3.0', 'cac-editable-is_column_editable' ),
			new Filter( 'cac/editable/editables_data', '3.0', 'cac-editable-editables_data' ),
			new Filter( 'cac/editable/options', '3.0', 'cac-editable-editables_data' ),
			new Filter( 'cac/inline-edit/ajax-column-save/value', '3.0', 'cac-inline-edit-ajax-column-save-value' ),
			new Filter( 'cac/addon/filtering/options', '3.0', 'cac-addon-filtering-options' ),
			new Filter( 'cac/addon/filtering/dropdown_top_label', '3.0', 'cac-addon-filtering-dropdown_top_label' ),
			new Filter( 'cac/addon/filtering/taxonomy/terms_args', '3.0', 'cac-addon-filtering-taxonomy-terms_args' ),
			new Filter( 'cac/addon/filtering/dropdown_empty_option', '3.0', 'cac-addon-filtering-taxonomy-terms_args' ),
			new Filter( 'cac/column/actions/action_links', '3.0', 'cac-column_actions-action_links' ),
			new Filter( 'cac/acf/format_acf_value', '3.0', 'cac-acf-format_acf_value' ),
			new Filter( 'cac/addon/filtering/taxonomy/terms_args', '3.0' ),
			new Filter( 'cac/column/meta/use_text_input', '3.0' ),
			new Filter( 'cac/hide_renewal_notice', '3.0' ),
			new Filter( 'acp/network_settings/groups', '3.4' ),
			new Filter( 'acp/settings/groups', '3.4' ),
		];

		$hooks[] = new Filter( 'cac/columns/custom', '3.0', 'cac-columns-custom' );

		foreach ( $this->get_types() as $type ) {
			$hooks[] = new Filter( 'cac/columns/custom/type=' . $type, '3.0', 'cac-columns-custom' );
		}

		foreach ( get_post_types() as $post_type ) {
			$hooks[] = new Filter( 'cac/columns/custom/post_type=' . $post_type, '3.0', 'cac-columns-custom' );
		}

		$hooks[] = new Filter( 'cac/column/value', '3.0', 'cac-column-value' );

		foreach ( $this->get_types() as $type ) {
			$hooks[] = new Filter( 'cac/column/value/' . $type, '3.0', 'cac-column-value' );
		}

		$hooks[] = new Filter( 'cac/editable/column_value', '3.0', 'cac-editable-column_value' );

		foreach ( $this->get_columns() as $column_type ) {
			$hooks[] = new Filter( 'cac/editable/column_value/column=' . $column_type, '3.0', 'cac-editable-column_value' );
		}

		$hooks[] = new Filter( 'cac/editable/column_save', '3.0', 'cac-editable-column_save' );

		foreach ( $this->get_columns() as $column_type ) {
			$hooks[] = new Filter( 'cac/editable/column_save/column=' . $column_type, '3.0', 'cac-editable-column_save' );
		}

		return $hooks;
	}

	/**
	 * @return array
	 */
	private function get_types() {
		return [ 'post', 'user', 'comment', 'link', 'media' ];
	}

	/**
	 * @return array
	 */
	private function get_columns() {
		$columns = [];

		foreach ( $this->list_screen_type_repository->find_all() as $item ) {
			$list_screen = $this->list_screen_factory->create( new ListScreenData( [ 'key' => $item->get_key() ] ) );

			if ( ! $list_screen ) {
				continue;
			}

			// TODO
//			foreach ( $this->column_types_repository->find( $list_screen ) as $column ) {
//				$columns[ $column->get_type() ] = $column->get_type();
//			}
		}

		return $columns;
	}

	/**
	 * @return Action[]
	 */
	private function get_actions() {
		return [
			new Action( 'cac/admin_head', '3.0', 'cac-admin_head' ),
			new Action( 'cac/loaded', '3.0', 'cac-loaded' ),
			new Action( 'cac/inline-edit/after_ajax_column_save', '3.0', 'cacinline-editafter_ajax_column_save' ),
			new Action( 'cac/settings/after_title', '3.0' ),
			new Action( 'cac/settings/form_actions', '3.0' ),
			new Action( 'cac/settings/sidebox', '3.0' ),
			new Action( 'cac/settings/form_columns', '3.0' ),
			new Action( 'cac/settings/after_columns', '3.0' ),
			new Action( 'cac/column/settings_meta', '3.0' ),
			new Action( 'cac/settings/general', '3.0' ),
			new Action( 'cpac_messages', '3.0' ),
			new Action( 'cac/settings/after_menu', '3.0' ),
			new Action( 'ac/settings/general', '3.4' ),
		];
	}

	/**
	 * @return Filter[]
	 */
	public function get_deprecated_filters() {
		return $this->check_deprecated_hooks( $this->get_filters() );
	}

	/**
	 * @return Action[]
	 */
	public function get_deprecated_actions() {
		return $this->check_deprecated_hooks( $this->get_actions() );
	}

	/**
	 * @param array $hooks
	 *
	 * @return array
	 */
	private function check_deprecated_hooks( $hooks ) {
		$deprecated = [];

		foreach ( $hooks as $hook ) {
			if ( $hook->has_hook() ) {
				$deprecated[] = $hook;
			}
		}

		return $deprecated;
	}

	/**
	 * @return int
	 */
	public function get_deprecated_count() {
		return count( $this->get_deprecated_actions() ) + count( $this->get_deprecated_filters() );
	}

}