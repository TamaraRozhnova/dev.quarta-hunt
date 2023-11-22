<?php

class ImportCatalog
{
	private          $ibFrom;
	private          $iblockTo;
	protected string $FILE_NAME;
	private string   $ABS_FILE_NAME;
	private          $siteId;

	public function __construct ( $ibFrom, $siteId )
	{
		$this->ibFrom = $ibFrom;
//		$this->iblockTo = $iblockTo;
		$this->siteId = $siteId;

		$this->FILE_NAME = "/upload/tmp/catalog.xml" ;
		$this->ABS_FILE_NAME = $_SERVER[ "DOCUMENT_ROOT" ] . $this->FILE_NAME;

		$this->exportIB();
		$this->replace();
	}

	private function exportIB()
	{
		[ $usec, $sec ] = explode( " ", microtime() );
		$start_time = ((float)$usec + (float)$sec);

		$WORK_DIR_NAME = substr( $this->ABS_FILE_NAME, 0, strrpos( $this->ABS_FILE_NAME, "/" ) + 1 );

		$_SESSION[ "BX_CML2_EXPORT" ] = array(
			"PROPERTY_MAP" => false,
			"SECTION_MAP" => false,
			"PRICES_MAP" => false,
		);

		$fp = fopen( $this->ABS_FILE_NAME, "wb" );
		$NS = array(
			"STEP" => 0,
			"IBLOCK_ID" => $this->ibFrom,
			"URL_DATA_FILE" => $this->FILE_NAME,
			"SECTIONS_FILTER" => "all",
			"ELEMENTS_FILTER" => "all",
			"DOWNLOAD_CLOUD_FILES" => "N",
			"next_step" => array(),
		);

		$DIR_NAME = substr( $this->ABS_FILE_NAME, 0, -4 ) . "_files";
		$_SESSION[ "BX_CML2_EXPORT" ][ "work_dir" ] = $WORK_DIR_NAME;
		$_SESSION[ "BX_CML2_EXPORT" ][ "file_dir" ] = substr( $DIR_NAME . "/", strlen( $WORK_DIR_NAME ) );


		$obExport = new \CIBlockCMLExport;
		$obExport->Init( $fp, $NS[ "IBLOCK_ID" ], $NS[ "next_step" ], true, $_SESSION[ "BX_CML2_EXPORT" ][ "work_dir" ], $_SESSION[ "BX_CML2_EXPORT" ][ "file_dir" ] );

		$obExport->StartExport();
		$obExport->StartExportMetadata();
		$obExport->ExportProperties( $_SESSION[ "BX_CML2_EXPORT" ][ "PROPERTY_MAP" ] );

		$obExport->ExportSections(
			$_SESSION[ "BX_CML2_EXPORT" ][ "SECTION_MAP" ], $start_time, 0,
			$NS[ "SECTIONS_FILTER" ], $_SESSION[ "BX_CML2_EXPORT" ][ "PROPERTY_MAP" ]
		);

		$obExport->EndExportMetadata();
		$obExport->StartExportCatalog();

		$obExport->ExportElements(
			$_SESSION[ "BX_CML2_EXPORT" ][ "PROPERTY_MAP" ], $_SESSION[ "BX_CML2_EXPORT" ][ "SECTION_MAP" ],
			$start_time, 0, 0, $NS[ "ELEMENTS_FILTER" ]
		);

		$obExport->EndExportCatalog();
		$obExport->ExportProductSets();
		$obExport->EndExport();
	}

	private function replace()
	{
		$xml = simplexml_load_file($this->ABS_FILE_NAME);

		$xml->Классификатор->Ид = 'catalog_'.$this->siteId ;
		$xml->ПакетПредложений->Ид = 'catalog_'.$this->siteId;
		$xml->ПакетПредложений->ИдКлассификатора = 'catalog_'.$this->siteId;
		$xml->ПакетПредложений->БитриксКод = 'catalog_' . $this->siteId;

		$xml->saveXML($this->ABS_FILE_NAME);
	}

	public function importIB()
	{
		$IBLOCK_ID = ImportXMLFile(
			$this->ABS_FILE_NAME, $this->siteId, $this->siteId, "N", "N",
			false, true, false, false, true );
	}

}
