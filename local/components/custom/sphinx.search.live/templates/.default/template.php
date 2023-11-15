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
                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.8082 15.885L13.2794 12.3562C14.5256 10.8721 15.1508 8.96421 15.0245 7.03043C14.8983 5.09664 14.0305 3.28623 12.6019 1.97673C11.1734 0.667227 9.29454 -0.040272 7.3571 0.00177205C5.41965 0.0438161 3.57323 0.832157 2.20287 2.2024C0.832506 3.57264 0.0440018 5.41899 0.00178652 7.35643C-0.0404288 9.29387 0.666904 11.1728 1.97628 12.6014C3.28566 14.0301 5.09599 14.8981 7.02976 15.0245C8.96353 15.1509 10.8715 14.5259 12.3557 13.2799L15.8845 16.8087C16.007 16.9312 16.1731 17 16.3463 17C16.5196 17 16.6857 16.9312 16.8082 16.8087C16.9307 16.6862 16.9995 16.5201 16.9995 16.3468C16.9995 16.1736 16.9307 16.0075 16.8082 15.885ZM1.32461 7.52938C1.32461 6.30218 1.68852 5.10254 2.37031 4.08216C3.05211 3.06178 4.02117 2.26649 5.15495 1.79686C6.28874 1.32723 7.53632 1.20436 8.73994 1.44377C9.94356 1.68319 11.0492 2.27414 11.9169 3.1419C12.7847 4.00966 13.3756 5.11526 13.615 6.31887C13.8545 7.52249 13.7316 8.77008 13.262 9.90386C12.7923 11.0376 11.997 12.0067 10.9767 12.6885C9.95628 13.3703 8.75664 13.7342 7.52944 13.7342C5.88439 13.7323 4.30724 13.078 3.14402 11.9148C1.98079 10.7516 1.32647 9.17443 1.32461 7.52938Z"
                                    fill="white"/>
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
                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.8082 15.885L13.2794 12.3562C14.5256 10.8721 15.1508 8.96421 15.0245 7.03043C14.8983 5.09664 14.0305 3.28623 12.6019 1.97673C11.1734 0.667227 9.29454 -0.040272 7.3571 0.00177205C5.41965 0.0438161 3.57323 0.832157 2.20287 2.2024C0.832506 3.57264 0.0440018 5.41899 0.00178652 7.35643C-0.0404288 9.29387 0.666904 11.1728 1.97628 12.6014C3.28566 14.0301 5.09599 14.8981 7.02976 15.0245C8.96353 15.1509 10.8715 14.5259 12.3557 13.2799L15.8845 16.8087C16.007 16.9312 16.1731 17 16.3463 17C16.5196 17 16.6857 16.9312 16.8082 16.8087C16.9307 16.6862 16.9995 16.5201 16.9995 16.3468C16.9995 16.1736 16.9307 16.0075 16.8082 15.885ZM1.32461 7.52938C1.32461 6.30218 1.68852 5.10254 2.37031 4.08216C3.05211 3.06178 4.02117 2.26649 5.15495 1.79686C6.28874 1.32723 7.53632 1.20436 8.73994 1.44377C9.94356 1.68319 11.0492 2.27414 11.9169 3.1419C12.7847 4.00966 13.3756 5.11526 13.615 6.31887C13.8545 7.52249 13.7316 8.77008 13.262 9.90386C12.7923 11.0376 11.997 12.0067 10.9767 12.6885C9.95628 13.3703 8.75664 13.7342 7.52944 13.7342C5.88439 13.7323 4.30724 13.078 3.14402 11.9148C1.98079 10.7516 1.32647 9.17443 1.32461 7.52938Z" fill="white"/>
                        </svg>
                    </button>
                </div>
            </form>
            <div class = 'search-live__items hide'></div>
            <div class = 'search-live__items-btn-cancel hide'></div>
        </div>
    </div>
<? endif; ?>


