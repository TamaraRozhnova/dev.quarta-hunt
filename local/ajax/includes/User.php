<?

namespace Cadesign\AjaxRequest;

use Bitrix\Main\UserTable;
use CUser;

class User extends \CAjaxRequest
{
	public function login ()
	{
		global $USER, $APPLICATION;
		$arResult = &$this->arResult;
		$arParams = &$this->arParams;

		if ($USER->IsAuthorized())
		{
			return [
				'TATUS' => 'error',
				'MESSAGE' => 'Вы уже авторизованы на сайте.',
			];
		}

		$arFilter = [
			[
				'LOGIC' => 'OR',
				[
					'LOGIN' => $arParams['email'],
				],
				[
					'EMAIL' => $arParams['email'],
				],
			],
		];
		$res = UserTable::getList( [ 'select' => [ 'ID', 'LOGIN' ], 'filter' => $arFilter, ] )->fetch();

		$obUser = new CUser();
		$arAuthResult = $obUser->Login( $res['LOGIN'], $arParams['pass'], 'Y' );
		$APPLICATION->arAuthResult = $arAuthResult;
		if ($arAuthResult === true)
		{
			$arResult = [ 'STATUS' => 'OK', 'MESSAGE' => 'Вы успешно авторизовались на сайте', ];
		}
		else
		{
			$arResult = $arAuthResult;
			$arResult['STATUS'] = 'error';
		}

		return $arResult;
	}

	public function register ()
	{
		global $USER;
		$arResult = &$this->arResult;
		$arParams = &$this->arParams;

		if ($USER->IsAuthorized())
		{
			return [
				'STATUS' => 'error',
				'MESSAGE' => 'Вы уже авторизованы на сайте.',
			];
		}

		$obUser = new CUser();
		$arResult = $obUser->Register( $arParams['email'], $arParams['name'], $arParams['last_name'], $arParams['pass'], $arParams['pass2'], $arParams['email'] );
		if ($arResult['TYPE'])
		{
			if ((int)$USER->GetID())
			{
				$arResult = [
					'STATUS' => 'OK',
					'MESSAGE' => 'Вы успешно зарегистрировались на сайте',
				];
			}
			else
			{
				$arResult['STATUS'] = $arResult['TYPE'];
			}
		}

		return $arResult;
	}
}
