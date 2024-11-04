<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 */
?>
<script id="basket-total-template" type="text/html">
    <div class="basket-checkout-container" data-entity="basket-checkout-aligner">
        <?
        if ($arParams['HIDE_COUPON'] !== 'Y')
        {
            ?>
            <div class="basket-coupon-section">
                <div class="basket-coupon-block-field">
                    <div class="basket-coupon-block-field-description">
                        <?=Loc::getMessage('SBB_COUPON_ENTER')?>:
                    </div>
                    <div class="form">
                        <div class="form-group" style="position: relative;">
                            <input type="text" class="form-control" id="" placeholder="" data-entity="basket-coupon-input">
                            <span class="basket-coupon-block-coupon-btn"></span>
                        </div>
                    </div>
                </div>
            </div>
            <?
        }
        ?>
        <div class="basket-checkout-section">
            <div class="basket-checkout-section-inner">
                <div class="basket-checkout-block basket-checkout-block-total">
                    <div class="basket-checkout-block-total-inner">
                        <div class="total-text"><?=Loc::getMessage('SBB_TOTAL')?>:</div>
                    </div>
                </div>

                <div class="basket-checkout-block basket-checkout-block-total-price">
                    <div class="basket-checkout-block-total-price-inner">
                        <div class="basket-coupon-block-total-price-current total-price" data-entity="basket-total-price">
                            {{{PRICE_FORMATED}}}
                        </div>
                        <div class="basket-info">
                            <div class="info-item">
                                <span class="info-title"><?=Loc::getMessage('TOTAL_PRODUCTS_COUNT')?></span>
                                <div class="basket-line"></div>
                                <span class="info-value">{{{COUNT_ITEMS}}} шт</span>
                            </div>
                            {{#DISCOUNT_PRICE_FORMATED}}
                            <div class="info-item">
                                <span class="info-title"><?=Loc::getMessage('BASKET_TOTAL_OLD_PRICE_TITLE')?></span>
                                <div class="basket-line"></div>
                                <span class="info-value">{{{PRICE_WITHOUT_DISCOUNT_FORMATED}}}</span>
                            </div>
                            {{/DISCOUNT_PRICE_FORMATED}}
                            {{#DISCOUNT_PRICE_FORMATED}}
                            <div class="info-item sale">
                                <span class="info-title"><?=Loc::getMessage('SBB_BASKET_ITEM_ECONOMY')?></span>
                                <div class="basket-line"></div>
                                <span class="info-value">-{{{DISCOUNT_PRICE_FORMATED}}}</span>
                            </div>
                            {{/DISCOUNT_PRICE_FORMATED}}
                        </div>
                    </div>
                </div>

                <div class="basket-checkout-block basket-checkout-block-btn">
                    <button class="to-order-button btn btn-lg btn-default basket-btn-checkout{{#DISABLE_CHECKOUT}} disabled{{/DISABLE_CHECKOUT}}"
                            data-entity="basket-checkout-button">
                        <?=Loc::getMessage('SBB_ORDER')?>
                    </button>
                </div>
            </div>
        </div>

        <?
        if ($arParams['HIDE_COUPON'] !== 'Y')
        {
            ?>
            <div class="basket-coupon-alert-section">
                <div class="basket-coupon-alert-inner">
                    {{#COUPON_LIST}}
                    <div class="basket-coupon-alert text-{{CLASS}}">
						<span class="basket-coupon-text">
							<strong>{{COUPON}}</strong> - <?=Loc::getMessage('SBB_COUPON')?> {{JS_CHECK_CODE}}
							{{#DISCOUNT_NAME}}({{DISCOUNT_NAME}}){{/DISCOUNT_NAME}}
						</span>
                        <span class="close-link" data-entity="basket-coupon-delete" data-coupon="{{COUPON}}">
							<?=Loc::getMessage('SBB_DELETE')?>
						</span>
                    </div>
                    {{/COUPON_LIST}}
                </div>
            </div>
            <?
        }
        ?>
    </div>
</script>