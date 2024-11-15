<?php

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bitrix\Main\Errorable;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Error;
use Bitrix\Iblock\Iblock;
use Bitrix\Main\Entity;
use Catalog\Orders\OrderHelper;

Loader::includeModule('iblock');
Loader::includeModule('highloadblock');

class ProductPersonalReviewsComponent extends CBitrixComponent implements Controllerable, Errorable
{
    /** @var ErrorCollection $errorCollection */
    protected ErrorCollection $errorCollection;

    /** @var CurrentUser $currentUser */
    private CurrentUser $currentUser;

    private array $productIds;
    private array $products = [];

    /**
     * @param CBitrixComponent|null $component
     *
     * @throws LoaderException
     */
    public function __construct(CBitrixComponent $component = null)
    {
        parent::__construct($component);
        $this->currentUser = CurrentUser::get();
    }

    /**
     * @param $arParams
     *
     * @return array
     */
    public function onPrepareComponentParams($arParams): array
    {
        $arParams['CACHE_TIME'] = (int)($arParams['CACHE_TIME'] ?? 36000000);

        $this->errorCollection = new ErrorCollection();

        return $arParams;
    }

    /**
     * @return void
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function executeComponent(): void
    {
        if (empty($this->arParams['CATALOG_ID'])) {
            ShowError(Loc::getMessage('NO_CATALOG_ID'));
            return;
        }

        if (empty($this->arParams['OFFERS_CATALOG_ID'])) {
            ShowError(Loc::getMessage('NO_OFFERS_CATALOG_ID'));
            return;
        }

        if ($this->currentUser->getId() == 0) {
            ShowError(Loc::getMessage('NO_USER'));
            return;
        }

        $this->getProducts();
        $this->getProductsInfo();

        $this->arResult['PROD_IDS'] = $this->productIds;
        $this->arResult['PRODUCTS'] = $this->products;
        $this->arResult['USER_ID'] = $this->currentUser->getId();

        $this->IncludeComponentTemplate();
    }

    /**
     * Получает ID купленных товаров и некоторую информацию по ним
     *
     * @return void
     */
    private function getProducts()
    {
        $orders = new OrderHelper($this->currentUser, $this->arParams['OFFERS_CATALOG_ID']);
        $this->productIds = $orders->getUserPurchasedProducts();

        if (!empty($this->productIds)) {
            $this->products = $orders->products;
        }
    }

    /**
     * Получает свойства товара
     *
     * @return void
     */
    private function getProductsInfo()
    {
        if (empty($this->products)) {
            return;
        }

        $catalogEntity = Iblock::wakeUp($this->arParams['CATALOG_ID'])->getEntityDataClass();
        $offersEntity = Iblock::wakeUp($this->arParams['OFFERS_CATALOG_ID'])->getEntityDataClass();

        foreach ($this->products as &$prod) {
            if (isset($prod['OFFER_ID'])) {
                $element = $offersEntity::getByPrimary($prod['OFFER_ID'], [
                    'select' => [
                        'NAME',
                        'HL_COLOR',
                        'HL_SIZE',
                        'COLOR_NAME' => 'HL_COLOR.UF_NAME',
                        'CLOTHES_SIZE_NAME' => 'HL_SIZE.UF_NAME',
                        'COLOR_FILE' => 'HL_COLOR.UF_FILE',
                        'COLOR_XML' => 'COLOR.VALUE',
                        'CLOTHES_SIZE_XML' => 'CLOTHES_SIZE.VALUE',
                    ],
                    'runtime' => [
                        new Entity\ReferenceField(
                            'HL_COLOR',
                            'Local\ORM\HutcolorsTable',
                            ['=this.COLOR.VALUE' => 'ref.UF_XML_ID']
                        ),
                        new Entity\ReferenceField(
                            'HL_SIZE',
                            'Local\ORM\HutclothessizeTable',
                            ['=this.CLOTHES_SIZE.VALUE' => 'ref.UF_XML_ID']
                        )
                    ]
                ])->fetch();

                $prod['PROPS'] = [
                    'COLOR' => $element['COLOR_NAME'],
                    'COLOR_FILE' => CFile::GetPath($element['COLOR_FILE']),
                    'SIZE' => $element['CLOTHES_SIZE_NAME'],
                ];
            }

            $element = $catalogEntity::getByPrimary($prod['PRODUCT_ID'], [
                'select' => [
                    'PREVIEW_PICTURE',
                    'IS_FULL_PREVIEW' => 'FULL_PREVIEW.VALUE'
                ],
            ])->fetch();

            $prod['IMG'] = CFile::GetPath($element['PREVIEW_PICTURE']);
            $prod['IS_FULL'] = $element['IS_FULL_PREVIEW'] ? "Y" : 'N';
        }
    }

    /**
     * @return array[]
     */
    public function configureActions(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getErrors(): array
    {
        return $this->errorCollection->toArray();
    }

    /**
     * @inheritdoc
     */
    public function getErrorByCode($code): Error
    {
        return $this->errorCollection->getErrorByCode($code);
    }
}
