<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);?>

<? if ($arParams['MOBILE'] != 'Y'): ?>
    <div class="header__search-section col">
        <div class = 'search-live__wrapper'>
            <form>
                <div class="input-group search-input">
                    <input type="text" class="search-live__input form-control border-primary bg-white"
                            placeholder="Искать товары..." value="<?= getSearchString() ?>"/>
                    <button class="btn btn-primary" type="submit">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.2939 12.5786L13.1504 11.4351L13.0703 12.2699C14.191 10.9663 14.8656 9.27387 14.8656 7.43282C14.8656 3.32762 11.538 0 7.43282 0C3.32762 0 0 3.32762 0 7.43282C0 11.538 3.32762 14.8656 7.43282 14.8656C9.27387 14.8656 10.9663 14.191 12.2699 13.0703L11.4351 13.1504L12.5786 14.2939L18.2962 20L20 18.2962L14.2939 12.5786ZM7.43282 12.5786C4.58548 12.5786 2.28702 10.2802 2.28702 7.43282C2.28702 4.58548 4.58548 2.28702 7.43282 2.28702C10.2802 2.28702 12.5786 4.58548 12.5786 7.43282C12.5786 10.2802 10.2802 12.5786 7.43282 12.5786Z" fill="white"/>
                        </svg>
                    </button>
                </div>
            </form>
            <div class = 'search-live__items hide'></div>
        </div>
    </div>
<? else: ?>
    <div class="header__search col">
        <div class = 'search-live__wrapper'>
            <form>
                <div class="input-group search-input">
                    <input type="text" class="search-live__input form-control border-primary bg-white py-2" placeholder="Искать товары..." />
                    <button class="btn btn-primary py-2 px-2" type="submit">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.2939 12.5786L13.1504 11.4351L13.0703 12.2699C14.191 10.9663 14.8656 9.27387 14.8656 7.43282C14.8656 3.32762 11.538 0 7.43282 0C3.32762 0 0 3.32762 0 7.43282C0 11.538 3.32762 14.8656 7.43282 14.8656C9.27387 14.8656 10.9663 14.191 12.2699 13.0703L11.4351 13.1504L12.5786 14.2939L18.2962 20L20 18.2962L14.2939 12.5786ZM7.43282 12.5786C4.58548 12.5786 2.28702 10.2802 2.28702 7.43282C2.28702 4.58548 4.58548 2.28702 7.43282 2.28702C10.2802 2.28702 12.5786 4.58548 12.5786 7.43282C12.5786 10.2802 10.2802 12.5786 7.43282 12.5786Z" fill="white"/>
                        </svg>
                    </button>
                </div>
            </form>
            <div class = 'search-live__items hide'></div>
            <div class = 'search-live__items-btn-cancel hide'></div>
        </div>
    </div>
<? endif; ?>



