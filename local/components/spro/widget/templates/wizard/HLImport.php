<?php

use Bitrix\Highloadblock as HL;
use Bitrix\Main\IO\File;

class HLImport
{
	private $filePath  = "";
	private $import;
	private $hlID      = false;
	private $tableName = false;
	private $fields    = [];
	private $tables    = [];
	private $siteId;
	private $domain;

	public function __construct ( $siteId, $domain )
	{
		$this->siteId = $siteId;
		CModule::IncludeModule( "highloadblock" );

		$this->domain = $domain;
	}

	public function start ($filePath)
	{
		$this->filePath = $filePath;
		$file = new File( $this->filePath );
		if ( !$file->isExists() || !$file->isReadable()) return;

		$this->import = new SimpleXMLElement( $file->getContents() );

		$this->createHL();
		if ($this->hlID)
		{
			$this->createFields();
			$this->loadItems();
		}
	}

	private function createHL (): void
	{
		$HL["NAME"] = $this->import->hiblock[0]->name->__toString(). 'Site' . $this->siteId;
		$HL["TABLE_NAME"] = $this->import->hiblock->table_name->__toString(). '_' . $this->siteId;

		$dbHblock = HL\HighloadBlockTable::getList( [ "filter" => [ "NAME" => $HL["NAME"] ] ] );
		if ( !$dbHblock->Fetch())
		{
			$result = HL\HighloadBlockTable::add( $HL );
			$this->hlID = $result->getId();
			$this->tableName = $HL["TABLE_NAME"] ;

			$this->tables[ $HL["TABLE_NAME"] ] = $this->hlID;

			$xmlLang = $this->import->langs;

			foreach ($xmlLang->lang as $lang)
			{
				$HL_lang = [
					"ID" => $this->hlID,
					"LID" => $lang->lid->__toString(),
					"name" => $lang->name->__toString() . ' [' . $this->domain . ']',
				];
				HL\HighloadBlockLangTable::add( $HL_lang );
			}
		}
	}

	private function createFields (): void
	{
		$fields = $this->import->fields;
		$obUserField = new CUserTypeEntity;
		foreach ($fields->field as $field)
		{
			$arFields = [
				'ENTITY_ID' => 'HLBLOCK_' . $this->hlID,
				'FIELD_NAME' => $field->field_name->__toString(),
				'USER_TYPE_ID' => $field->user_type_id->__toString(),
				'XML_ID' => $field->field_name->__toString(),
				'SORT' => $field->sort->__toString(),
				'MULTIPLE' => $field->multiple->__toString(),
				'MANDATORY' => $field->mandatory->__toString(),
				'SHOW_FILTER' => $field->show_filter->__toString(),
				'SHOW_IN_LIST' => $field->show_in_list->__toString(),
				'EDIT_IN_LIST' => $field->edit_in_list->__toString(),
				'IS_SEARCHABLE' => $field->is_searchable->__toString(),

			];

			$SETTINGS = (array)$field->settings;

			foreach ($SETTINGS as $key => $item)
			{
				if ($key == 'label_checkbox')
				{
					$item = $item->__toString();
				}

				if ($key == 'label')
				{
					$item = (array)$item->item;
				}

				if (is_object( $item ))
				{
					$item = $item->__toString();
				}

				$arFields["SETTINGS"][ strtoupper( $key ) ] = $item;
			}

			if ($arFields["USER_TYPE_ID"] == 'hlblock')
			{
				$table = $arFields["SETTINGS"]["HLBLOCK_TABLE"];
				$arFields["SETTINGS"]['HLBLOCK_ID'] = $this->tables[ $table ];
				$arFields["SETTINGS"]['HLFIELD_ID'] = $this->fields[ $this->tables[ $table ] ]["UF_NAME"];
			}

			$dbRes = CUserTypeEntity::GetList( [], [ "ENTITY_ID" => $arFields["ENTITY_ID"], "FIELD_NAME" => $arFields["FIELD_NAME"] ] );
			if ($dbRes->Fetch()) continue;

			$arFields["EDIT_FORM_LABEL"] = (array)$field->edit_form_label;
			$arFields["LIST_COLUMN_LABEL"] = (array)$field->list_column_label;
			$arFields["LIST_FILTER_LABEL"] = (array)$field->list_filter_label;
			$arFields["ERROR_MESSAGE"] = (array)$field->error_message;
			$arFields["HELP_MESSAGE"] = (array)$field->help_message;

			$ID_USER_FIELD = $obUserField->Add( $arFields );

			$this->fields[ $this->hlID ][ $arFields["FIELD_NAME"] ] = $ID_USER_FIELD;
		}
	}

	private function loadItems (): void
	{
		$hldata = HL\HighloadBlockTable::getById( $this->hlID )->fetch();
		$hlentity = HL\HighloadBlockTable::compileEntity( $hldata );
		$entity_data_class = $hlentity->getDataClass();

		$items = $this->import->items->item;

		$imgDir = str_replace( ".xml", "_files/", $this->filePath );
		foreach ($items as $item)
		{
			$arData = (array)$item;

			foreach ($arData as $key => $item)
			{
				if (is_object( $item ))
				{
					$arData[ $key ] = $item->__toString();
				}

				$arItem[ strtoupper( $key ) ] = $arData[ $key ];
			}

			if ($arItem['UF_FILE'])
			{
				$arItem['UF_FILE'] = CFile::MakeFileArray( $imgDir . $arItem['UF_FILE'] );
			}

			if ($arItem["UF_GROUP"])
			{
				$arItem["UF_GROUP"] = unserialize( str_replace( "serialize#", "", htmlspecialchars_decode( $arItem["UF_GROUP"] ) ) );
			}

			$result = $entity_data_class::add( $arItem );
		}
	}
}
