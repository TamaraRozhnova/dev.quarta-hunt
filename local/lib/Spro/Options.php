<?php


namespace Spro;


use Bitrix\Main\Config\Option as BxOption;

class Option extends BxOption
{
	public static function changeOptions($module, $config, $value)
	{
		parent::$options[ $module ][ '-' ][ $config ] = $value;
	}

}
