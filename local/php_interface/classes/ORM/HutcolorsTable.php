<?php

namespace Local\ORM;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\TextField;

/**
 * Class HutcolorsTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> UF_NAME text optional
 * <li> UF_SORT int optional
 * <li> UF_XML_ID text optional
 * <li> UF_LINK text optional
 * <li> UF_DESCRIPTION text optional
 * <li> UF_FULL_DESCRIPTION text optional
 * <li> UF_DEF int optional
 * <li> UF_FILE int optional
 * </ul>
 *
 * @package Bitrix\Hlbd
 **/

class HutcolorsTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'b_hlbd_hutcolors';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return [
			new IntegerField(
				'ID',
				[
					'primary' => true,
					'autocomplete' => true,
					'title' => Loc::getMessage('HUTCOLORS_ENTITY_ID_FIELD'),
				]
			),
			new TextField(
				'UF_NAME',
				[
					'title' => Loc::getMessage('HUTCOLORS_ENTITY_UF_NAME_FIELD'),
				]
			),
			new IntegerField(
				'UF_SORT',
				[
					'title' => Loc::getMessage('HUTCOLORS_ENTITY_UF_SORT_FIELD'),
				]
			),
			new TextField(
				'UF_XML_ID',
				[
					'title' => Loc::getMessage('HUTCOLORS_ENTITY_UF_XML_ID_FIELD'),
				]
			),
			new TextField(
				'UF_LINK',
				[
					'title' => Loc::getMessage('HUTCOLORS_ENTITY_UF_LINK_FIELD'),
				]
			),
			new TextField(
				'UF_DESCRIPTION',
				[
					'title' => Loc::getMessage('HUTCOLORS_ENTITY_UF_DESCRIPTION_FIELD'),
				]
			),
			new TextField(
				'UF_FULL_DESCRIPTION',
				[
					'title' => Loc::getMessage('HUTCOLORS_ENTITY_UF_FULL_DESCRIPTION_FIELD'),
				]
			),
			new IntegerField(
				'UF_DEF',
				[
					'title' => Loc::getMessage('HUTCOLORS_ENTITY_UF_DEF_FIELD'),
				]
			),
			new IntegerField(
				'UF_FILE',
				[
					'title' => Loc::getMessage('HUTCOLORS_ENTITY_UF_FILE_FIELD'),
				]
			),
		];
	}
}
