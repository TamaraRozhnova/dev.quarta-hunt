<?
/**
 * Единый входной файл для аякс запросов.
 * Уже подключено ядро битрикса, подключены инфоблоки
 */

use Bitrix\Main\Application;
use Bitrix\Main\IO\File;
use Bitrix\Main\Loader;

define( "NO_KEEP_STATISTIC", true ); //Не учитываем статистику
define( "NOT_CHECK_PERMISSIONS", true ); //Не учитываем права доступа
define( "SHOW_NEW_DESIGN_ADMIN", true );
define( "PUBLIC_AJAX_MODE", true );
require($_SERVER[ "DOCUMENT_ROOT" ] . "/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->ShowIncludeStat = false;

class CAjaxRequest
{
	protected $arParams;
	protected $arResult;
	private $ajaxDir = "/local/ajax/includes";

	public function __construct(&$arParams = array(), &$arResult = array())
	{
		$this->arParams = &$arParams;
		$this->arResult = &$arResult;
	}

	private function forSql($array)
	{
		$connection = Application::getConnection();
		$sqlHelper = $connection->getSqlHelper();

		foreach ( $array as &$item )
		{
			if ( is_array( $item ) )
			{
				$item = $this->forSql( $item );
			}
			else
			{
				$item = $sqlHelper->forSql( $item  );
			}
		}

		return $array;
	}

	private function forOut($array)
	{
		foreach ( $array as &$item )
		{
			if ( is_array( $item ) )
			{
				$item = $this->forOut( $item );
			}
			else
			{
				$item = $item;
			}
		}

		return $array;
	}

	public function execute()
	{
		Loader::includeModule( "main" );
		Loader::includeModule( "iblock" );
		Loader::includeModule( "catalog" );
		Loader::includeModule( "sale" );

		$this->arParams = $this->forSql( $_POST );
		foreach ( $_POST as $key => $value )
		{
			$this->arParams[ "~" . $key ] = $value;
		}

		$action = explode( "/", $this->arParams[ 'action' ] );

		$fullPath = Application::getDocumentRoot() . $this->ajaxDir . "/" . $action[ 0 ] . '.php';
		$file = new File( $fullPath );

		if ( !$file->isExists() || !$file->isReadable() )
		{
			$this->arResult = array(
				"STATUS" => "ERROR",
				"MESSAGE" => "Action not found",
			);
		}
		else
		{
			$arResult = &$this->arResult;
			$arParams = &$this->arParams;
			include $fullPath;

			if ( isset( $action[ 1 ] ) )
			{
				$className = 'Cadesign\AjaxRequest\\' . $action[ 0 ];
				if ( class_exists( $className ) )
				{
					$classAction = new $className( $arParams, $arResult );
					if ( method_exists( $classAction, $action[ 1 ] ) )
					{
						$arResult = $classAction->{$action[ 1 ]}();
					}
					else
					{
						$this->arResult = array(
							"STATUS" => "ERROR",
							"MESSAGE" => "Action not found",
						);
					}
				}
				else
				{
					$this->arResult = array(
						"STATUS" => "ERROR",
						"MESSAGE" => "Action not found",
					);
				}

			}
		}
		$this->arResult[ "INPUT" ] = $this->arParams;

		if ( strlen( $this->arParams[ "ajaxCallback" ] ) && ( !isset( $this->arResult[ 'ajaxCallback' ] ) || empty( $this->arResult[ 'ajaxCallback' ] )) )
			$this->arResult[ 'ajaxCallback' ] = $this->arParams[ "ajaxCallback" ];

		$toOut = $this->forOut($this->arResult);

		echo json_encode( $toOut );
	}
}

$ajaxRequest = new CAjaxRequest();
$ajaxRequest->execute();

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
die();
