<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Security\Random;

/**
 * 1) проверка директорий сайтов
 * 2) Создать сайт в админке.
 * 3) сохранить значения формы (ИБ, оплата и тд)
 * 4) скопировать файлы сайта. Cкопировать главную
 *      4.а) лого
 *      4.б) залить ИБ из xml
 * 5) заменить параметры в компонентах
 *      5.а) HL-блок соц сетей
 * 6) добавить поле ввода ID раздела и копирование элементов ИБ
 * 7) добавить ограничение по сайтам на доставку и оплату
 */
class SiteWizard
{
	private const IB_LIST = [
		//4 COption::GetOptionString( 'spro.wizard', 'ib-main-slider',  '', SITE_ID ),
		'main-slider',
		//8 COption::GetOptionString( 'spro.wizard', 'ib-tizers',  '', SITE_ID ),
		'tizers',
		//6 COption::GetOptionString( 'spro.wizard', 'ib-glasses',  '', SITE_ID ),
		'glasses',
		//5 COption::GetOptionString( 'spro.wizard', 'ib-pistol',  '', SITE_ID ),
		'pistol',
		//10 COption::GetOptionString( 'spro.wizard', 'ib-faq',  '', SITE_ID ),
		'faq',
		//7 COption::GetOptionString( 'spro.wizard', 'ib-media',  '', SITE_ID ),
		'media',
		//2 COption::GetOptionString( 'spro.wizard', 'ib-catalog',  '', SITE_ID ),
		'catalog',
		//9 COption::GetOptionString( 'spro.wizard', 'ib-review',  '', SITE_ID ),
		'review',
		//1 COption::GetOptionString( 'spro.wizard', 'ib-news',  '', SITE_ID ),
		'news',
		'about-photo', //COption::GetOptionString( 'spro.wizard', 'ib-about-photo',  '', SITE_ID ),
	];

	public string $LAST_ERROR;
	/**
	 * @var array
	 */
	private array $wizard;
	/**
	 * @var array
	 */
	private array $lid = [];
	/**
	 * @var string
	 */
	private string $siteId;

//	private array $iblocks = [];

	/**
	 * @param array $wizard
	 */
	public function __construct ( array $wizard )
	{
		$this->wizard = $wizard;
		define('SPRO_WIZARD_DOMAIN', $this->wizard['domain']);

		$this->loadExistsSites();
		$this->getRandomLid();
	}

	public function run (): bool
	{
		$res = $this->checkDirs();
		if ( !$res)
		{
			$this->LAST_ERROR = 'Не корректно настроен document root';

			return false;
		}

		$this->createSite();
		$this->saveProps();
		$this->copyFiles();
		$this->importDB();
		$this->importCatalog();

		return true;
	}

	private function loadExistsSites (): void
	{
		$rsSites = CSite::GetList();
		while ($arSite = $rsSites->Fetch())
		{
			$this->lid[] = $arSite['LID'];
		}
	}

	private function getRandomLid (): void
	{
		$this->siteId = Random::getString( 2 );
		if (in_array( $this->siteId, $this->lid ))
		{
			$this->getRandomLid();
		}
	}

	private function createSite (): void
	{
		$arFields = [
			"LID" => $this->siteId,
			"ACTIVE" => "Y",
			"SORT" => 200,
			"DEF" => "N",
			"NAME" => $this->wizard['domain'],
			"DIR" => '/',
			"FORMAT_DATE" => "DD.MM.YYYY",
			"FORMAT_DATETIME" => "DD.MM.YYYY HH:MI:SS",
			"SITE_NAME" => $this->wizard['domain'],
			"SERVER_NAME" => $this->wizard['domain'],
			"EMAIL" => "admin@" . $this->wizard['domain'],
			"LANGUAGE_ID" => "ru",
			"CULTURE_ID" => 1,
			"DOC_ROOT" => $this->wizard['document_root'],
			"DOMAINS" => $this->wizard['domain'],
			'TEMPLATE' => [
				[
					'CONDITION' => "",
					'SORT' => 1,
					'TEMPLATE' => "stalker",
				],
			],
		];
		$obSite = new CSite;
		$obSite->Add( $arFields );
	}

	private function checkDirs (): bool
	{
		$docRootExist = $this->dirExists( $this->wizard['document_root'] );
		$bxExist = $this->dirExists( $this->wizard['document_root'] . '/bitrix' );
		$localExist = $this->dirExists( $this->wizard['document_root'] . '/local' );

		if(!$localExist)
		{
			symlink($_SERVER['DOCUMENT_ROOT'] . '/local', $this->wizard['document_root'] . '/local');
			$localExist = $this->dirExists( $this->wizard['document_root'] . '/local' );
		}

		$uploadExist = $this->dirExists( $this->wizard['document_root'] . '/upload' );

		$settingsExists = file_exists( $this->wizard['document_root'] . '/bitrix/.settings.php' );

		return $docRootExist &&
			$bxExist &&
			$localExist &&
			$uploadExist &&
			$settingsExists;
	}

	private function dirExists ( $dirPath ): bool
	{
		return file_exists( $dirPath ) && is_dir( $dirPath );
	}

	private function saveProps (): void
	{
		COption::SetOptionString( 'spro.wizard', 'catalog', $this->wizard['catalog'], '', $this->siteId );
		$image = $_FILES["logo"];
		$image["MODULE_ID"] = "spro.wizard";
		$file = CFile::SaveFile( $image, 'spro' );

		COption::SetOptionString( 'spro.wizard', 'logo', $file, '', $this->siteId );
		COption::SetOptionString( 'spro.wizard', 'payment', json_encode($this->wizard['payment']), '', $this->siteId );
		COption::SetOptionString( 'spro.wizard', 'delivery', json_encode($this->wizard['delivery']), '', $this->siteId );
	}

	private function copyFiles (): void
	{
		CopyDirFiles(
			realpath( __DIR__ . '/../../site' ),
			$this->wizard['document_root'],
			true,
			true,
			false,
			'tpl.'
		);
		CopyDirFiles(
			realpath( __DIR__ . '/../../site/tpl.index-' . $this->wizard['main'] . '.php' ),
			$this->wizard['document_root'] . '/index.php'
		);

		$logoFile = $this->wizard['document_root'] . '/_includes/logo.php';
		$img = COption::GetOptionString( 'spro.wizard', 'logo', '', SITE_ID );
		$imgPath = CFile::GetPath( $img );
		file_put_contents( $logoFile, '<img src="' . $imgPath . '" alt=""/>' );
	}

	private function importDB (): void
	{
		Loader::includeModule( 'iblock' );

		include_once 'copy.php';
		include_once 'HLImport.php';
		$ob = new ImportDB( $this->siteId, $this->wizard['domain'] );

		foreach (static::IB_LIST as $ib)
		{
			$id = $ob->import( $ib );
//			$this->iblocks[ $ib ] = $id;
			COption::SetOptionString( 'spro.wizard', 'ib-' . $ib, $id, '', $this->siteId );
		}

		$file = realpath( __DIR__ . '/../../xml/' ) . '/orig-hl_social.xml';
		$hl = new HLImport( $this->siteId, $this->wizard['domain'] );
		$hl->start( $file );
	}

	private function importCatalog ()
	{
		include_once 'ImportCatalog.php';

		$importCatalog = new ImportCatalog(
			$this->wizard[ 'catalog' ],
			$this->siteId
		);
		$importCatalog->importIB();
	}
}
