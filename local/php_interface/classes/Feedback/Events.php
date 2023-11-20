<?php

namespace Feedback;

use Feedback\Review;
use CIBlockElement;

/**
 * События для блока отзывов
 */
class Events
{
    const PRODUCT_RATING_PROPERTY_CODE = 'RATING';   
    
    /**
     * Обновляет свойство Рейтинг товара после обновления элемента инфоблока отзывов.
     *
     * @param array $arFields Массив полей элемента.
     */
    public static function updateProductAfterReviewChange(&$arFields) {
        if ($arFields['IBLOCK_ID'] != REVIEWS_IBLOCK_ID) {
            return;
        }

        $element = \Bitrix\Iblock\Elements\ElementFeedbackTable::getByPrimary($arFields['ID'], [
            'select' => ['ID', 'DETAIL_PICTURE', 'PRODUCT_ID_' => 'PRODUCT_ID.ELEMENT'],
        ])->fetch();

        if (is_array($element) && count($element)) {
            $reviews = new Review();
            $ratings = $reviews->getReviewsRatingAndCountForProducts([$element['PRODUCT_ID_ID']]);
        }

        if(is_array($ratings) && count($ratings)) {
            CIBlockElement::SetPropertyValuesEx($element['PRODUCT_ID_ID'], false, array(self::PRODUCT_RATING_PROPERTY_CODE => (float)$ratings[$element['PRODUCT_ID_ID']]['RATING']));
        } else {
            CIBlockElement::SetPropertyValuesEx($element['PRODUCT_ID_ID'], false, array(self::PRODUCT_RATING_PROPERTY_CODE => ''));
        }
    }
}