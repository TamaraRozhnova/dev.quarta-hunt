<?php

use Catalog\Rating\DTO\RatingDTO;
use Catalog\Rating\Enum\RatingGrade;
use Catalog\Rating\Service\RatingManager;
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

class ProductRatingComponent extends CBitrixComponent implements Controllerable, Errorable
{
    /** @var ErrorCollection $errorCollection */
    protected ErrorCollection $errorCollection;

    /** @var CurrentUser $currentUser */
    private CurrentUser $currentUser;

    /** @var RatingManager $ratingManager */
    private RatingManager $ratingManager;

    /**
     * @param CBitrixComponent|null $component
     *
     * @throws LoaderException
     */
    public function __construct(CBitrixComponent $component = null)
    {
        parent::__construct($component);

        Loader::includeModule('addamant.thanks');

        $this->currentUser = CurrentUser::get();
        $this->ratingManager = new RatingManager();
    }

    /**
     * @param $arParams
     *
     * @return array
     */
    public function onPrepareComponentParams($arParams): array
    {
        $arParams['ELEMENT_ID'] = (int)($arParams['ELEMENT_ID'] ?? 0);
        $arParams['IBLOCK_ID'] = (int)($arParams['IBLOCK_ID'] ?? 0);

        /* ------------------------------------------------ Кеширование --------------------------------------------- */
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
        if (empty($this->arParams['ELEMENT_ID'])) {
            ShowError(Loc::getMessage('NO_ELEMENT_ID'));
            return;
        }

        if (empty($this->arParams['IBLOCK_ID'])) {
            ShowError(Loc::getMessage('NO_IBLOCK_ID'));
            return;
        }

        $this->arResult = $this->ratingManager->getProductRatingInfo(
            0,
            $this->arParams['IBLOCK_ID'],
            $this->arParams['ELEMENT_ID'],
        );
        $this->arResult['CURRENT_USER_RATING'] = $this->ratingManager->getRatingByUserId(
            $this->currentUser->getId(),
            $this->arParams['IBLOCK_ID'],
            $this->arParams['ELEMENT_ID'],
        );

        $this->IncludeComponentTemplate();
    }

    /**
     * @param int $grade
     *
     * @return array
     */
    public function setRatingAction(int $grade): array
    {
        try {
            $grade = RatingGrade::from($grade);

            $currentUserRating = $this->ratingManager->getRatingByUserId(
                $this->currentUser->getId(),
                $this->arParams['IBLOCK_ID'],
                $this->arParams['ELEMENT_ID'],
            );

            if ($ratingId = $currentUserRating['ID']) {
                $setRatingResult = $this->ratingManager->updateRating($ratingId, $grade);
            } else {
                $setRatingResult = $this->ratingManager->addRating(
                    new RatingDTO(
                        $this->currentUser->getId(),
                        $this->arParams['IBLOCK_ID'],
                        $this->arParams['ELEMENT_ID'],
                        $grade
                    ),
                );
            }

            if (!$setRatingResult->isSuccess()) {
                $this->errorCollection->add($setRatingResult->getErrors());
                return [
                    'RESULT' => Loc::getMessage('ERROR_SET_RATING'),
                    'AVERAGE_RATING' => $setRatingResult->getData()['AVERAGE_RATING'],
                ];
            }

            return ['RESULT' => Loc::getMessage('SUCCESS_SET_RATING'),];
        } catch (Throwable $throwable) {
            $this->errorCollection->add([new Error($throwable->getMessage())]);
            return ['RESULT' => Loc::getMessage('ERROR_SET_RATING')];
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

    /**
     * @return string[]
     */
    protected function listKeysSignedParameters(): array
    {
        return
            [
                'ELEMENT_ID',
                'IBLOCK_ID',
            ];
    }
}
