<?php
namespace AC;

use AC\Settings\Column\BeforeAfter;
use AC\Settings\Column\CharacterLimit;
use AC\Settings\Column\Label;
use AC\Settings\Column\PostFormatIcon;
use AC\Settings\Column\Width;
use AC\Settings\Column\WordLimit;
use AC\Type\ColumnData;
use LogicException;

class ColumnSettingFactory {

	public function create( $type, ColumnData $data ) {

		switch ( $type ) {
			case BeforeAfter::NAME :
				return new BeforeAfter( $data->get( BeforeAfter::OPTION_BEFORE ), $data->get( BeforeAfter::OPTION_AFTER ) );
			case CharacterLimit::NAME :
				return new CharacterLimit( $data->get( CharacterLimit::OPTION_LIMIT ) );
			case Label::NAME :
				return new Label( $data->get( Label::NAME ) );
			case PostFormatIcon::NAME :
				return new PostFormatIcon();
			case Width::NAME :
				return new Width( $data->get( Width::OPTION_WIDTH ), $data->get( Width::OPTION_WIDTH_UNIT ) );
			case WordLimit::NAME :
				return new WordLimit( $data->get( WordLimit::OPTION_LIMIT ) );
		}

		throw new LogicException( 'Setting not found.' );
	}

}