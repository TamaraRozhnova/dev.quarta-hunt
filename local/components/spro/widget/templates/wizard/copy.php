<?php

class ImportDB
{
	private string $siteId = '';
	private string $ABS_FILE_NAME;
	private string $xmlFrom;
	private string $domain;

	public function __construct ( $siteId, $domain )
	{
		$this->siteId = $siteId;
		$this->domain = $domain;

		$this->createTypeIB();
	}

	public function import ( $xmlFrom )
	{
		$this->xmlFrom = $xmlFrom;
		$this->copyFile();

		$IBLOCK_ID = ImportXMLFile(
			$this->ABS_FILE_NAME, $this->siteId, $this->siteId, "N", "N",
			false, true, false, false, true );

		unlink( $this->ABS_FILE_NAME );

		return $IBLOCK_ID;
	}

	private function replace (): void
	{
		$arrSearch1 = [ "#IB_ID#" ];
		$arrReplace1 = [ $this->xmlFrom . '_' . $this->siteId ];

		$arrSearch2 = [ "#DOMAIN#" ];
		$arrReplace2 = [ SPRO_WIZARD_DOMAIN ];

		if ( !$handle = @fopen( $this->ABS_FILE_NAME, "rb" )) return;

		$content = @fread( $handle, filesize( $this->ABS_FILE_NAME ) );
		@fclose( $handle );

		if ( !( $handle = @fopen( $this->ABS_FILE_NAME, "wb" ) )) return;

		if (flock( $handle, LOCK_EX ))
		{
			$content = str_replace( $arrSearch1, $arrReplace1, $content );
			$content = str_replace( $arrSearch2, $arrReplace2, $content );
			@fwrite( $handle, $content );
			@flock( $handle, LOCK_UN );
		}
		@fclose( $handle );
	}

	private function copyFile (): void
	{
		if ($this->xmlFrom && $this->siteId)
		{
			$pathFileFrom = realpath( __DIR__ . '/../../xml/orig-' . $this->xmlFrom . '.xml' );
			$pathFileTo = realpath( __DIR__ . '/../../xml/' ) . '/' . $this->xmlFrom . '.xml';

			CopyDirFiles(
				$pathFileFrom,
				$pathFileTo
			);

			$this->ABS_FILE_NAME = $pathFileTo;

			$this->replace();
		}
	}

	private function createTypeIB (): void
	{
		$arFields = [
			'ID' => $this->siteId,
			'SECTIONS' => 'Y',
			'IN_RSS' => 'N',
			'SORT' => 100,
			'LANG' => [
				'ru' => [
					'NAME' => $this->domain,
					'SECTION_NAME' => 'Разделы',
					'ELEMENT_NAME' => 'Элементы',
				],
				'en' => [
					'NAME' => $this->domain,
					'SECTION_NAME' => 'Разделы',
					'ELEMENT_NAME' => 'Элементы',
				],
			],
		];

		$obBlockType = new CIBlockType;
		$obBlockType->Add( $arFields );
	}
}
