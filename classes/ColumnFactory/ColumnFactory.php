<?php

namespace AC\ColumnFactory;

use AC\Column;
use AC\Column\CustomField;
use AC\Column\Post;
use AC\Column\User;
use AC\ColumnFactoryInterface;
use AC\ColumnSettingFactory;
use AC\ListScreen;
use AC\Settings\Column\BeforeAfter;
use AC\Settings\Column\Label;
use AC\Settings\Column\Width;
use AC\Settings\Column\WordLimit;
use AC\Settings\ColumnSettingsCollection;
use AC\Type\ColumnData;
use InvalidArgumentException;

class ColumnFactory implements ColumnFactoryInterface {

	const LIST_KEY = 'list_key';
	const NAME = 'name';
	const TYPE = 'type';
	const LABEL = 'label';
	const POST_TYPE = 'post_type';
	const META_TYPE = 'meta_type';

	/**
	 * @var ColumnSettingFactory
	 */
	private $columnSettingFactory;

	public function __construct( ColumnSettingFactory $columnSettingFactory ) {
		$this->columnSettingFactory = $columnSettingFactory;
	}

	public function create( ColumnData $data ) {
		if ( ! $data->exists( self::LIST_KEY ) ) {
			throw new InvalidArgumentException( sprintf( 'Missing %s argument.', self::LIST_KEY ) );
		}

		if ( ! $data->exists( self::TYPE ) ) {
			throw new InvalidArgumentException( sprintf( 'Missing %s argument.', self::TYPE ) );
		}

		if ( ! $data->exists( self::NAME ) ) {
			// TODO create Name object with generate method
			$data[ self::NAME ] = uniqid();
		}

		switch ( $data[ self::LIST_KEY ] ) {

			// TODO Comment\Media

			case ListScreen\User::NAME :
				$column = $this->create_user_column( $data );
				break;
			default :
				$column = $this->create_post_type_column( $data );
		}

		return apply_filters( 'ac/column', $column, $data );
	}

	/**
	 * @param ColumnData $data
	 *
	 * @return Column|null
	 */
	protected function create_post_type_column( ColumnData $data ) {

		switch ( $data->get( self::TYPE ) ) {

			// TODO all columns

			case Post\Attachment::TYPE :
				return new Post\Attachment(
					$data->get( self::NAME ),
					new ColumnSettingsCollection(
						[
							// TODO Settings\Column\AttachmentDisplay
						]
					) );
			case Post\Formats::TYPE :
				return new Post\Formats(
					$data->get( self::NAME ),
					new ColumnSettingsCollection(
						[
							// TODO Settings\Column\PostFormatIcon
						]
					) );
			case Post\ID::TYPE :
				return new Post\ID(
					$data->get( self::NAME ),
					new ColumnSettingsCollection( [
						$this->columnSettingFactory->create( Label::NAME, $data ),
						$this->columnSettingFactory->create( Width::NAME, $data ),
						$this->columnSettingFactory->create( BeforeAfter::NAME, $data )
					] )
				);
			case Post\PageTemplate::TYPE :
				return new Post\PageTemplate(
					$data->get( self::NAME ),
					$data->get( self::POST_TYPE ),
					new ColumnSettingsCollection( [
						$this->columnSettingFactory->create( Label::NAME, $data ),
						$this->columnSettingFactory->create( Width::NAME, $data )
					] )
				);
			case CustomField::TYPE :
				return new CustomField(
					$data->get( self::NAME ),
					$data->get( self::META_TYPE ),
					new ColumnSettingsCollection( [
						// TODO
					] )
				);
			default :
				return $this->create_default( $data );
		}
	}

	/**
	 * @param ColumnData $data
	 *
	 * @return Column|null
	 */
	protected function create_user_column( ColumnData $data ) {

		switch ( $data->get( self::TYPE ) ) {
			case User\Description::TYPE :
				return new User\Description(
					$data->get( self::NAME ),
					new ColumnSettingsCollection( [
						$this->columnSettingFactory->create( BeforeAfter::NAME, $data ),
						$this->columnSettingFactory->create( WordLimit::NAME, $data ),
					] )
				);
			case CustomField::TYPE :
				return new CustomField(
					$data->get( self::NAME ),
					$data->get( self::META_TYPE ),
					new ColumnSettingsCollection( [
						// TODO
					] )
				);
			default :
				return $this->create_default( $data );
		}
	}

	protected function create_default( ColumnData $data ) {
		return new Column(
			$data->get( self::TYPE ),
			$data->get( self::TYPE ),
			new ColumnSettingsCollection( [
				$this->columnSettingFactory->create( Label::NAME, $data ),
				$this->columnSettingFactory->create( Width::NAME, $data )
			] )
		);
	}

}