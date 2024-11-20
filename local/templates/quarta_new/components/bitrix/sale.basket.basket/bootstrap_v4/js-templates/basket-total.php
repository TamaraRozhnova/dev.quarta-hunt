<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

global $USER;

$isAuth = $USER->IsAuthorized();

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
							<span class=" basket-coupon-block-coupon-btn"></span>
						</div>
					</div>

				</div>
			</div>
			<?
		}
		?>
		<div class="basket-checkout-section">
			<div class="basket-checkout-section-inner<?=(($arParams['HIDE_COUPON'] == 'Y') ? ' justify-content-between' : '')?>">

                <div class="basket-checkout-block basket-checkout-block-total-price">
                    <div class="basket-checkout-block-total-price-inner <?=!$isAuth ? 'hide' : null?>">

                        <div class="basket-coupon-block-total-price-current" data-entity="basket-total-price">
                            <div class="basket-checkout-block-total-title"><?=Loc::getMessage('SBB_TOTAL')?> ({{{BASKET_ITEM_COUNT}}} <?= Loc::getMessage('SBB_TOTAL_M') ?>):</div>
                            <div class="basket-checkout-block-total__text">{{{PRICE_FORMATED}}}</div>
                        </div>

						{{#DISCOUNT_PRICE_FORMATED}}
                        <div class="basket-coupon-block-total-price-old">
                            {{{PRICE_WITHOUT_DISCOUNT_FORMATED}}}
                        </div>
                        {{/DISCOUNT_PRICE_FORMATED}}

                        {{#DISCOUNT_PRICE_FORMATED}}
                        <div class="basket-coupon-block-total-price-difference">
                            <?=Loc::getMessage('SBB_BASKET_ITEM_ECONOMY')?>
                            <span style="white-space: nowrap;">{{{DISCOUNT_PRICE_FORMATED}}}</span>
                        </div>
                        {{/DISCOUNT_PRICE_FORMATED}}
                    </div>
                </div>

                <div class="basket-checkout-block-total__separator"></div>

                <div class="basket-checkout-block-total__description">
					<? if ($isAuth): ?>
						<?=Loc::getMessage('BALLS_TEXT');?>
					<? else: ?>
						<?=Loc::getMessage('BALLS_NOAUTH_TEXT');?>
					<? endif;?>
                </div>

				<div class="basket-checkout-block basket-checkout-block-btn">
					<button class="btn btn-lg btn-primary basket-btn-checkout{{#DISABLE_CHECKOUT}} disabled{{/DISABLE_CHECKOUT}}"
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