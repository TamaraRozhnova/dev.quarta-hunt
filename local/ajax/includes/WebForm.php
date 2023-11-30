<?

namespace Cadesign\AjaxRequest;

use COption;

class WebForm extends \CAjaxRequest
{
	public function feedback()
	{
		$connection = \Bitrix\Main\Application::getConnection();
		$connection->add("sp_feedback", array(
			"UF_NAME" => $this->arParams[ "name" ],
			"UF_EMAIL" => $this->arParams[ "email" ],
			"UF_MESSAGE" => $this->arParams[ "message" ],
			"UF_TYPE" => "Форма обратной связи на сайте " . $_SERVER['SERVER_NAME'],
		));

		\Bitrix\Main\Mail\Event::send(
			array(
				"EVENT_NAME" => "SP_FEEDBACK",
				"LID" => 's1',
				"C_FIELDS" => array(
					"UF_TYPE" => "Форма обратной связи на сайте " . $_SERVER['SERVER_NAME'],
					"EMAIL" => $this->arParams[ "email" ],
					"NAME" => $this->arParams[ "name" ],
					"MESSAGE" => $this->arParams[ "message" ],
				),
			)
		);

		return array("STATUS" => "OK", "MESSAGE" => "Ваше сообщение успешно отправлено. Наш менеджер свяжется с Вами в ближайшее время");
	}

	public function addReview()
	{
		global $USER;
		$el = new \CIBlockElement;
		$PROP = [
			"USER_ID" => $USER->GetID(),
			"PRODUCT" => intval($this->arParams[ "productID" ]),
			"EMAIL" => $this->arParams[ "email" ]
		];

		$arLoadProductArray = [
			"MODIFIED_BY" => $USER->GetID(),
			"IBLOCK_SECTION_ID" => false,
			"IBLOCK_CODE" => SITE_ID,
			"IBLOCK_ID" => IBLOCKS['ib-review'],
			"ACTIVE_FROM" => date("d.m.Y H:i:s"),
			"PROPERTY_VALUES" => $PROP,
			"NAME" => $this->arParams[ "name" ],
			"ACTIVE" => "N",
			"PREVIEW_TEXT" => $this->arParams[ "message" ],
			"PREVIEW_PICTURE" => $_FILES['file'],
		];

		if ($PRODUCT_ID = $el->Add($arLoadProductArray))
		{
			$result = [
				"STATUS" => "OK",
				"MESSAGE" => "Ваш отзыв успешно добавлен. Он будет опубликован на сайте после проверки модератором"
			];
			\Bitrix\Main\Mail\Event::send(
				[
					"EVENT_NAME" => "NEW_REVIEW",
					"LID" => SITE_ID,
					"C_FIELDS" => array(
						"ID_REVIEW" => $PRODUCT_ID,
					),
				]
			);
		}
		else
		{
			$result[ "STATUS" ] = 'ERROR';
			$result[ "MESSAGE" ] = $el->LAST_ERROR;
		}

		return $result;
	}
}