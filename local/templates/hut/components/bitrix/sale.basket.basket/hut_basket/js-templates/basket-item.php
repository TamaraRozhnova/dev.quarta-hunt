<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $mobileColumns
 * @var array $arParams
 * @var string $templateFolder
 */

$usePriceInAdditionalColumn = in_array('PRICE', $arParams['COLUMNS_LIST']) && $arParams['PRICE_DISPLAY_MODE'] === 'Y';
$useSumColumn = in_array('SUM', $arParams['COLUMNS_LIST']);
$useActionColumn = in_array('DELETE', $arParams['COLUMNS_LIST']);

$restoreColSpan = 2 + $usePriceInAdditionalColumn + $useSumColumn + $useActionColumn;

$positionClassMap = array(
	'left' => 'basket-item-label-left',
	'center' => 'basket-item-label-center',
	'right' => 'basket-item-label-right',
	'bottom' => 'basket-item-label-bottom',
	'middle' => 'basket-item-label-middle',
	'top' => 'basket-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}
?>
<script id="basket-item-template" type="text/html">
	<tr class="basket-item basket-items-list-item-container{{#SHOW_RESTORE}} basket-items-list-item-container-expend{{/SHOW_RESTORE}}"
		id="basket-item-{{ID}}" data-entity="basket-item" data-id="{{ID}}">
		{{#SHOW_RESTORE}}
			<td class="basket-items-list-item-notification" colspan="<?=$restoreColSpan?>">
				<div class="basket-items-list-item-notification-inner basket-items-list-item-notification-removed" id="basket-item-height-aligner-{{ID}}">
					{{#SHOW_LOADING}}
						<div class="basket-items-list-item-overlay"></div>
					{{/SHOW_LOADING}}
					<div class="basket-items-list-item-removed-container">
						<div>
							<?=Loc::getMessage('SBB_GOOD_CAP')?> <strong>{{NAME}}</strong> <?=Loc::getMessage('SBB_BASKET_ITEM_DELETED')?>.
						</div>
						<div class="basket-items-list-item-removed-block">
							<a href="javascript:void(0)" data-entity="basket-item-restore-button">
								<?=Loc::getMessage('SBB_BASKET_ITEM_RESTORE')?>
							</a>
							<span class="basket-items-list-item-clear-btn" data-entity="basket-item-close-restore-button"></span>
						</div>
					</div>
				</div>
			</td>
		{{/SHOW_RESTORE}}
		{{^SHOW_RESTORE}}
			<td class="basket-items-list-item-descriptions">
				<div class="basket-items-list-item-descriptions-inner" id="basket-item-height-aligner-{{ID}}">
					<?
					if (in_array('PREVIEW_PICTURE', $arParams['COLUMNS_LIST']))
					{
						?>
						<div class="basket-item-block-image<?=(!isset($mobileColumns['PREVIEW_PICTURE']) ? ' hidden-xs' : '')?>">
							{{#DETAIL_PAGE_URL}}
								<a href="{{DETAIL_PAGE_URL}}" class="basket-item-image-link image-block">
							{{/DETAIL_PAGE_URL}}

							<img class="basket-item-image" alt="{{NAME}}"
								src="{{{IMAGE_URL}}}{{^IMAGE_URL}}<?=$templateFolder?>/images/no_photo.png{{/IMAGE_URL}}">

							{{#SHOW_LABEL}}
								<div class="basket-item-label-text basket-item-label-big <?=$labelPositionClass?>">
									{{#LABEL_VALUES}}
										<div{{#HIDE_MOBILE}} class="hidden-xs"{{/HIDE_MOBILE}}>
											<span title="{{NAME}}">{{NAME}}</span>
										</div>
									{{/LABEL_VALUES}}
								</div>
							{{/SHOW_LABEL}}
							{{#DETAIL_PAGE_URL}}
								</a>
							{{/DETAIL_PAGE_URL}}
						</div>
						<?
					}
					?>
					{{#SHOW_LOADING}}
						<div class="basket-items-list-item-overlay"></div>
					{{/SHOW_LOADING}}
				</div>
			</td>
            <td class="item-info-block">
                <div class="remove-item-block">
                    <div class="remove-item-content">
                        <span><?=Loc::getMessage('DELETE_TITLE')?></span>
                        <div class="buttons-block">
                            <span class="close-remove-item"><?=Loc::getMessage('DELETE_TITLE_NO')?></span>
                            <span class="remove-item" data-entity="basket-item-delete"><?=Loc::getMessage('DELETE_TITLE_YES')?></span>
                        </div>
                    </div>
                </div>
                <div class="item-info-block">
                    <span class="basket-item-info-name item-name">
                        {{#DETAIL_PAGE_URL}}
                        <a href="{{DETAIL_PAGE_URL}}" class="basket-item-info-name-link">
                            {{/DETAIL_PAGE_URL}}

                            <span data-entity="basket-item-name">{{NAME}}</span>

                            {{#DETAIL_PAGE_URL}}
                        </a>
                        {{/DETAIL_PAGE_URL}}
                    </span>
                    <span class="item-section">
                        {{SECTION_NAME}}
                    </span>
                    {{#NOT_AVAILABLE}}
                    <div class="basket-items-list-item-warning-container">
                        <div class="alert alert-warning text-center">
                            <?=Loc::getMessage('SBB_BASKET_ITEM_NOT_AVAILABLE')?>.
                        </div>
                    </div>
                    {{/NOT_AVAILABLE}}
                    {{#DELAYED}}
                    <div class="basket-items-list-item-warning-container">
                        <div class="alert alert-warning text-center">
                            <?=Loc::getMessage('SBB_BASKET_ITEM_DELAYED')?>.
                            <a href="javascript:void(0)" data-entity="basket-item-remove-delayed">
                                <?=Loc::getMessage('SBB_BASKET_ITEM_REMOVE_DELAYED')?>
                            </a>
                        </div>
                    </div>
                    {{/DELAYED}}
                    {{#WARNINGS.length}}
                    <div class="basket-items-list-item-warning-container">
                        <div class="alert alert-warning alert-dismissable" data-entity="basket-item-warning-node">
                            <span class="close" data-entity="basket-item-warning-close">&times;</span>
                            {{#WARNINGS}}
                            <div data-entity="basket-item-warning-text">{{{.}}}</div>
                            {{/WARNINGS}}
                        </div>
                    </div>
                    {{/WARNINGS.length}}
                    <div class="basket-item-block-properties item-prop-info-block">
                        <?
                        if (!empty($arParams['PRODUCT_BLOCKS_ORDER']))
                        {
                            foreach ($arParams['PRODUCT_BLOCKS_ORDER'] as $blockName)
                            {
                                switch (trim((string)$blockName))
                                {
                                    case 'props':
                                        if (in_array('PROPS', $arParams['COLUMNS_LIST']))
                                        {
                                            ?>
                                            {{#PROPS}}
                                            <div data-prop-code="{{CODE}}" class="prop-info basket-item-property<?=(!isset($mobileColumns['PROPS']) ? ' hidden-xs' : '')?>">
                                                <span class="basket-item-property-name prop-name">
                                                    {{{NAME}}}
                                                </span>
                                                <span class="basket-item-property-value prop-value"
                                                     data-entity="basket-item-property-value" data-property-code="{{CODE}}">
                                                    {{{VALUE}}}
                                                </span>
                                            </div>
                                            {{/PROPS}}
                                            <?
                                        }

                                        break;
                                    case 'sku':
                                        ?>
                                        {{#SKU_BLOCK_LIST}}
                                        {{#IS_IMAGE}}
                                        <div class="basket-item-property basket-item-property-scu-image"
                                             data-entity="basket-item-sku-block">
                                            <div class="basket-item-property-name">{{NAME}}</div>
                                            <div class="basket-item-property-value">
                                                <ul class="basket-item-scu-list">
                                                    {{#SKU_VALUES_LIST}}
                                                    <li class="basket-item-scu-item{{#SELECTED}} selected{{/SELECTED}}
																		{{#NOT_AVAILABLE_OFFER}} not-available{{/NOT_AVAILABLE_OFFER}}"
                                                        title="{{NAME}}"
                                                        data-entity="basket-item-sku-field"
                                                        data-initial="{{#SELECTED}}true{{/SELECTED}}{{^SELECTED}}false{{/SELECTED}}"
                                                        data-value-id="{{VALUE_ID}}"
                                                        data-sku-name="{{NAME}}"
                                                        data-property="{{PROP_CODE}}">
																				<span class="basket-item-scu-item-inner"
                                                                                      style="background-image: url({{PICT}});"></span>
                                                    </li>
                                                    {{/SKU_VALUES_LIST}}
                                                </ul>
                                            </div>
                                        </div>
                                        {{/IS_IMAGE}}

                                        {{^IS_IMAGE}}
                                        <div class="basket-item-property basket-item-property-scu-text"
                                             data-entity="basket-item-sku-block">
                                            <div class="basket-item-property-name">{{NAME}}</div>
                                            <div class="basket-item-property-value">
                                                <ul class="basket-item-scu-list">
                                                    {{#SKU_VALUES_LIST}}
                                                    <li class="basket-item-scu-item{{#SELECTED}} selected{{/SELECTED}}
																		{{#NOT_AVAILABLE_OFFER}} not-available{{/NOT_AVAILABLE_OFFER}}"
                                                        title="{{NAME}}"
                                                        data-entity="basket-item-sku-field"
                                                        data-initial="{{#SELECTED}}true{{/SELECTED}}{{^SELECTED}}false{{/SELECTED}}"
                                                        data-value-id="{{VALUE_ID}}"
                                                        data-sku-name="{{NAME}}"
                                                        data-property="{{PROP_CODE}}">
                                                        <span class="basket-item-scu-item-inner">{{NAME}}</span>
                                                    </li>
                                                    {{/SKU_VALUES_LIST}}
                                                </ul>
                                            </div>
                                        </div>
                                        {{/IS_IMAGE}}
                                        {{/SKU_BLOCK_LIST}}

                                        {{#HAS_SIMILAR_ITEMS}}
                                        <div class="basket-items-list-item-double" data-entity="basket-item-sku-notification">
                                            <div class="alert alert-info alert-dismissable text-center">
                                                {{#USE_FILTER}}
                                                <a href="javascript:void(0)"
                                                   class="basket-items-list-item-double-anchor"
                                                   data-entity="basket-item-show-similar-link">
                                                    {{/USE_FILTER}}
                                                    <?=Loc::getMessage('SBB_BASKET_ITEM_SIMILAR_P1')?>{{#USE_FILTER}}</a>{{/USE_FILTER}}
                                                <?=Loc::getMessage('SBB_BASKET_ITEM_SIMILAR_P2')?>
                                                {{SIMILAR_ITEMS_QUANTITY}} {{MEASURE_TEXT}}
                                                <br>
                                                <a href="javascript:void(0)" class="basket-items-list-item-double-anchor"
                                                   data-entity="basket-item-merge-sku-link">
                                                    <?=Loc::getMessage('SBB_BASKET_ITEM_SIMILAR_P3')?>
                                                    {{TOTAL_SIMILAR_ITEMS_QUANTITY}} {{MEASURE_TEXT}}?
                                                </a>
                                            </div>
                                        </div>
                                        {{/HAS_SIMILAR_ITEMS}}
                                        <?
                                        break;
                                    case 'columns':
                                        ?>
                                        {{#COLUMN_LIST}}
                                        {{#IS_IMAGE}}
                                        <div class="basket-item-property-custom prop-info basket-item-property-custom-photo
														{{#HIDE_MOBILE}}hidden-xs{{/HIDE_MOBILE}}"
                                             data-entity="basket-item-property">
                                            <span class="basket-item-property-custom-name prop-name">{{NAME}}:</span>
                                            <span class="basket-item-property-custom-value">
                                                {{#VALUE}}
                                                <span>
																	<img class="basket-item-custom-block-photo-item"
                                                                         src="{{{IMAGE_SRC}}}" data-image-index="{{INDEX}}"
                                                                         data-column-property-code="{{CODE}}">
																</span>
                                                {{/VALUE}}
                                            </span>
                                        </div>
                                        {{/IS_IMAGE}}

                                        {{#IS_TEXT}}
                                        <div data-prop-code="{{CODE}}" class="basket-item-property-custom prop-info basket-item-property-custom-text
														{{#HIDE_MOBILE}}hidden-xs{{/HIDE_MOBILE}}"
                                             data-entity="basket-item-property">
                                            <span class="basket-item-property-custom-name prop-name">{{NAME}}:</span>
                                            {{#CIRCLE_COLOR}}
                                                <span class="color-circle" style="background-color: {{CIRCLE_COLOR}}"></span>
                                            {{/CIRCLE_COLOR}}
                                            <span class="basket-item-property-custom-value prop-value"
                                                 data-column-property-code="{{CODE}}"
                                                 data-entity="basket-item-property-column-value">
                                                {{VALUE}}
                                            </span>
                                        </div>
                                        {{/IS_TEXT}}

                                        {{#IS_HTML}}
                                        <div class="basket-item-property-custom prop-info basket-item-property-custom-text
														{{#HIDE_MOBILE}}hidden-xs{{/HIDE_MOBILE}}"
                                             data-entity="basket-item-property">
                                            <span class="basket-item-property-custom-name prop-name">{{NAME}}:</span>
                                            <span class="basket-item-property-custom-value prop-value"
                                                 data-column-property-code="{{CODE}}"
                                                 data-entity="basket-item-property-column-value">
                                                {{{VALUE}}}
                                            </span>
                                        </div>
                                        {{/IS_HTML}}

                                        {{#IS_LINK}}
                                        <div class="basket-item-property-custom prop-info basket-item-property-custom-text
														{{#HIDE_MOBILE}}hidden-xs{{/HIDE_MOBILE}}"
                                             data-entity="basket-item-property">
                                            <span class="basket-item-property-custom-name prop-name">{{NAME}}:</span>
                                            <span class="basket-item-property-custom-value prop-value"
                                                 data-column-property-code="{{CODE}}"
                                                 data-entity="basket-item-property-column-value">
                                                {{#VALUE}}
                                                {{{LINK}}}{{^IS_LAST}}<br>{{/IS_LAST}}
                                                {{/VALUE}}
                                            </span>
                                        </div>
                                        {{/IS_LINK}}
                                        {{/COLUMN_LIST}}
                                        <?
                                        break;
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </td>
			<?
			if ($usePriceInAdditionalColumn)
			{
				?>
                <td class="right-item-block basket-items-list-item-price basket-items-list-item-price-for-one">
                    <div class="count-price-item-block">
                        <div class="count-price-block">
                            <div class="count-price-block basket-item-block-amount{{#NOT_AVAILABLE}} disabled{{/NOT_AVAILABLE}}"
                                 data-entity="basket-item-quantity-block">
                                <span class="basket-item-amount-btn-minus" data-entity="basket-item-quantity-minus">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.41797 10C3.41797 9.58579 3.75376 9.25 4.16797 9.25H15.8346C16.2488 9.25 16.5846 9.58579 16.5846 10C16.5846 10.4142 16.2488 10.75 15.8346 10.75H4.16797C3.75376 10.75 3.41797 10.4142 3.41797 10Z" fill="#DCDCDF"/>
                                </svg>
                                </span>
                                <div class="basket-item-amount-filed-block">
                                    <input type="text" class="basket-item-amount-filed" value="{{QUANTITY}}"
                                           {{#NOT_AVAILABLE}} disabled="disabled"{{/NOT_AVAILABLE}}
                                    data-value="{{QUANTITY}}" data-entity="basket-item-quantity-field"
                                    id="basket-item-quantity-{{ID}}">
                                </div>
                                <span class="basket-item-amount-btn-plus" data-entity="basket-item-quantity-plus">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.0013 3.1665C10.5536 3.1665 11.0013 3.61422 11.0013 4.1665V8.99984H15.8346C16.3869 8.99984 16.8346 9.44755 16.8346 9.99984C16.8346 10.5521 16.3869 10.9998 15.8346 10.9998H11.0013V15.8332C11.0013 16.3855 10.5536 16.8332 10.0013 16.8332C9.44902 16.8332 9.0013 16.3855 9.0013 15.8332V10.9998H4.16797C3.61568 10.9998 3.16797 10.5521 3.16797 9.99984C3.16797 9.44755 3.61568 8.99984 4.16797 8.99984H9.0013V4.1665C9.0013 3.61422 9.44902 3.1665 10.0013 3.1665Z" fill="#EC6624"/>
                                    </svg>
                                </span>
                                {{#SHOW_LOADING}}
                                <div class="basket-items-list-item-overlay"></div>
                                {{/SHOW_LOADING}}
                            </div>
                        </div>
                        <div class="price-block">
                            <div class="basket-item-block-price">
                                <div class="basket-item-price-current">
                                    <span class="basket-item-price-current-text item-price
                                        {{#SHOW_DISCOUNT_PRICE}}
                                            item-sale-price
                                        {{/SHOW_DISCOUNT_PRICE}}
                                    " id="basket-item-price-{{ID}}">
                                        {{{PRICE_FORMATED}}}
                                    </span>
                                </div>
                                {{#SHOW_DISCOUNT_PRICE}}
                                    <div class="basket-item-price-old">
                                        <span class="basket-item-price-old-text old-price">
                                            {{{FULL_PRICE_FORMATED}}}
                                        </span>
                                    </div>
                                {{/SHOW_DISCOUNT_PRICE}}

                                {{#SHOW_LOADING}}
                                <div class="basket-items-list-item-overlay"></div>
                                {{/SHOW_LOADING}}
                            </div>
                        </div>
                    </div>
                    <div class="basket-item-block-actions delete-basket-item">
						<span class="basket-item-actions-remove">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10 3.75C9.9337 3.75 9.87011 3.77634 9.82322 3.82322C9.77634 3.87011 9.75 3.9337 9.75 4V6.25H14.25V4C14.25 3.9337 14.2237 3.87011 14.1768 3.82322C14.1299 3.77634 14.0663 3.75 14 3.75H10ZM15.75 6.25V4C15.75 3.53587 15.5656 3.09075 15.2374 2.76256C14.9092 2.43437 14.4641 2.25 14 2.25H10C9.53587 2.25 9.09075 2.43437 8.76256 2.76256C8.43437 3.09075 8.25 3.53587 8.25 4V6.25H5.00877C5.00349 6.24994 4.9982 6.24994 4.9929 6.25H4C3.58579 6.25 3.25 6.58579 3.25 7C3.25 7.41421 3.58579 7.75 4 7.75H4.3099L5.25021 19.0337C5.25898 19.7508 5.54767 20.4368 6.05546 20.9445C6.57118 21.4603 7.27065 21.75 8 21.75H16C16.7293 21.75 17.4288 21.4603 17.9445 20.9445C18.4523 20.4368 18.741 19.7508 18.7498 19.0337L19.6901 7.75H20C20.4142 7.75 20.75 7.41421 20.75 7C20.75 6.58579 20.4142 6.25 20 6.25H19.0071C19.0018 6.24994 18.9965 6.24994 18.9912 6.25H15.75ZM15 7.75H9H5.8151L6.74741 18.9377C6.74914 18.9584 6.75 18.9792 6.75 19C6.75 19.3315 6.8817 19.6495 7.11612 19.8839C7.35054 20.1183 7.66848 20.25 8 20.25H16C16.3315 20.25 16.6495 20.1183 16.8839 19.8839C17.1183 19.6495 17.25 19.3315 17.25 19C17.25 18.9792 17.2509 18.9584 17.2526 18.9377L18.1849 7.75H15ZM10 10.25C10.4142 10.25 10.75 10.5858 10.75 11V17C10.75 17.4142 10.4142 17.75 10 17.75C9.58579 17.75 9.25 17.4142 9.25 17V11C9.25 10.5858 9.58579 10.25 10 10.25ZM14 10.25C14.4142 10.25 14.75 10.5858 14.75 11V17C14.75 17.4142 14.4142 17.75 14 17.75C13.5858 17.75 13.25 17.4142 13.25 17V11C13.25 10.5858 13.5858 10.25 14 10.25Z" fill="#354052"/>
                            </svg>
                        </span>
                        {{#SHOW_LOADING}}
                            <div class="basket-items-list-item-overlay"></div>
                        {{/SHOW_LOADING}}
                    </div>
                </td>
				<?
			}
			?>
		{{/SHOW_RESTORE}}
	</tr>
</script>