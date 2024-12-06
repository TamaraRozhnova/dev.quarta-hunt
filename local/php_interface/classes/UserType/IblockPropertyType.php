<?php

namespace UserType;

use Bitrix\Main\Loader;
use Bitrix\Main\UserField\Types\EnumType;
use Bitrix\Main\Type;
use Bitrix\Iblock;

class IblockPropertyType extends EnumType
{
    public const
        USER_TYPE_ID = 'iblock_property',
        RENDER_COMPONENT = 'bitrix:iblock.field.element';

    protected static ?bool $iblockIncluded = null;

    /**
     * @return array
     */
    public static function getDescription(): array
    {
        return [
            'DESCRIPTION' => 'Привязка к свойствам инфоблока',
            'BASE_TYPE' => \CUserTypeManager::BASE_TYPE_INT,
        ];
    }

    /**
     * @param array $userField
     * @return array
     */
    public static function prepareSettings(array $userField): array
    {
        $height = (int)($userField['SETTINGS']['LIST_HEIGHT'] ?? 1);
        $disp = ($userField['SETTINGS']['DISPLAY'] ?? '');

        if ($disp !== static::DISPLAY_CHECKBOX && $disp !== static::DISPLAY_LIST) {
            $disp = static::DISPLAY_LIST;
        }

        $iblockId = (int)($userField['SETTINGS']['IBLOCK_ID'] ?? 0);

        if ($iblockId <= 0) {
            $iblockId = '';
        }

        $propertyId = (int)($userField['SETTINGS']['DEFAULT_VALUE'] ?? 0);

        if ($propertyId <= 0) {
            $elementId = '';
        }

        $activeFilter = (($userField['SETTINGS']['ACTIVE_FILTER'] ?? '') === 'Y' ? 'Y' : 'N');

        return [
            'DISPLAY' => $disp,
            'LIST_HEIGHT' => (max($height, 1)),
            'IBLOCK_ID' => $iblockId,
            'DEFAULT_VALUE' => $elementId,
            'ACTIVE_FILTER' => $activeFilter,
        ];
    }

    /**
     * @param array $userField
     * @return string|null
     */
    public static function onSearchIndex(array $userField): ?string
    {
        $res = '';
        if (!isset($userField['VALUE'])) {
            return $res;
        }

        if (is_array($userField['VALUE'])) {
            $val = $userField['VALUE'];
        } else {
            $val = [$userField['VALUE']];
        }

        Type\Collection::normalizeArrayValuesByInt($val);

        if (!empty($val) && Loader::includeModule('iblock')) {
            $iterator = Iblock\PropertyTable::getList([
                'select' => [
                    'NAME',
                    'ID',
                ],
                'filter' => [
                    '@ID' => $val,
                ],
            ]);
            while ($row = $iterator->fetch()) {
                $res .= $row['NAME'] . '[' . $row['ID'] . ']' . "\r\n";
            }
            unset($row, $iterator);
        }
        unset($val);

        return $res;
    }

    /**
     * @param array $userField
     * @return bool|CDBResult
     */
    public static function getList(array $userField)
    {
        $iblockId = (int)($userField['SETTINGS']['IBLOCK_ID'] ?? 0);
        $activeFilter = (string)($userField['SETTINGS']['ACTIVE_FILTER'] ?? 'N');

        if (self::$iblockIncluded === null) {
            self::$iblockIncluded = Loader::includeModule('iblock');
        }
        if ($iblockId <= 0 || !self::$iblockIncluded) {
            return false;
        }

        $cacheTtl = 86400;

        $iblockRights = self::getIblockRightsMode($iblockId, $cacheTtl);
        if ($iblockRights === null) {
            return false;
        }

        $result = false;
        $filter = [
            'IBLOCK_ID' => $iblockId,
        ];
        if ($activeFilter === 'Y') {
            $filter['=ACTIVE'] = 'Y';
        }

        $rows = [];
        $elements = \Bitrix\Iblock\PropertyTable::getList([
            'select' => [
                'ID',
                'NAME',
            ],
            'filter' => $filter,
            'order' => [
                'ID' => 'ASC',
                'NAME' => 'ASC',
            ],
            'cache' => [
                'ttl' => $cacheTtl,
            ],
        ]);

        while ($element = $elements->fetch()) {
            $rows[] = $element;
        }
        unset($elements);

        if (!empty($rows)) {
            $result = new IBlockElementEnum();
            $result->InitFromArray($rows);
        }
        unset($rows);


        return $result;
    }

    /**
     * @param array $userField
     * @param array $additionalParameters
     */
    public static function getEnumList(array &$userField, array $additionalParameters = []): void
    {
        if (self::$iblockIncluded === null) {
            self::$iblockIncluded = Loader::includeModule('iblock');
        }

        $userField['MANDATORY'] ??= 'N';
        $userField['SETTINGS']['IBLOCK_ID'] ??= 0;
        $userField['SETTINGS']['SHOW_NO_VALUE'] ??= 'Y';
        $userField['SETTINGS']['DISPLAY'] ??= '';
        $userField['SETTINGS']['ACTIVE_FILTER'] ??= 'N';

        if (
            !self::$iblockIncluded
            || (int)$userField['SETTINGS']['IBLOCK_ID'] <= 0
        ) {
            return;
        }

        $result = [];
        $showNoValue = (
            $userField['MANDATORY'] !== 'Y'
            || $userField['SETTINGS']['SHOW_NO_VALUE'] !== 'N'
            || (
                isset($additionalParameters['SHOW_NO_VALUE'])
                && $additionalParameters['SHOW_NO_VALUE'] === true
            )
        );

        if (
            $showNoValue
            && (
                $userField['SETTINGS']['DISPLAY'] !== 'CHECKBOX'
                || $userField['MULTIPLE'] !== 'Y'
            )
        ) {
            $result = [
                null => static::getEmptyCaption($userField),
            ];
        }

        $filter = [];
        if (isset($additionalParameters['CURRENT_VALUES'])) {
            if (is_array($additionalParameters['CURRENT_VALUES'])) {
                Type\Collection::normalizeArrayValuesByInt($additionalParameters['CURRENT_VALUES']);
            } else {
                $additionalParameters['CURRENT_VALUES'] = (int)$additionalParameters['CURRENT_VALUES'];
                if ($additionalParameters['CURRENT_VALUES'] <= 0) {
                    $additionalParameters['CURRENT_VALUES'] = null;
                }
            }
            if (!empty($additionalParameters['CURRENT_VALUES'])) {
                $filter['ID'] = $additionalParameters['CURRENT_VALUES'];
            }
        }
        $filter['ACTIVE'] = $userField['SETTINGS']['ACTIVE_FILTER'] === 'Y';

        $elements = self::getElements(
            (int)$userField['SETTINGS']['IBLOCK_ID'],
            $filter
        );

        if (!is_array($elements)) {
            return;
        }

        if (!empty($additionalParameters['CURRENT_VALUES'])) {
            $result = $elements;
        } else {
            $result = array_replace($result, $elements);
        }

        $userField['USER_TYPE']['FIELDS'] = $result;
    }

    public static function getDefaultValue(array $userField, array $additionalParameters = [])
    {
        $value = ($userField['SETTINGS']['DEFAULT_VALUE'] ?? '');
        return ($userField['MULTIPLE'] === 'Y' ? [$value] : $value);
    }

    protected static function getElements(int $iblockId, array $additionalFilter = [])
    {
        if (self::$iblockIncluded === null) {
            self::$iblockIncluded = Loader::includeModule('iblock');
        }
        if ($iblockId <= 0 || !self::$iblockIncluded) {
            return false;
        }

        $cacheTtl = 86400;

        $iblockRights = self::getIblockRightsMode($iblockId, $cacheTtl);
        if ($iblockRights === null) {
            return false;
        }

        $filter = ['IBLOCK_ID' => $iblockId];
        if ($additionalFilter['ACTIVE']) {
            $filter['=ACTIVE'] = 'Y';
        }
        if (isset($additionalFilter['ID'])) {
            $filter['@ID'] = $additionalFilter['ID'];
        }

        $result = [];
        $elements = \Bitrix\Iblock\PropertyTable::getList([
            'select' => [
                'ID',
                'NAME',
            ],
            'filter' => $filter,
            'order' => [
                'ID' => 'ASC',
                'NAME' => 'ASC',
            ],
            'cache' => [
                'ttl' => $cacheTtl,
            ],
        ]);

        while ($element = $elements->fetch()) {
            $result[$element['ID']] = $element['NAME'] . ' [' . $element['ID'] . ']';
        }
        unset($element, $elements);

        if (empty($result)) {
            $result = false;
        }

        return $result;
    }

    private static function getIblockRightsMode(int $iblockId, int $cacheTtl): ?string
    {
        $iblock = Iblock\IblockTable::getRow([
            'select' => [
                'ID',
                'RIGHTS_MODE',
            ],
            'filter' => [
                '=ID' => $iblockId,
            ],
            'cache' => [
                'ttl' => $cacheTtl,
            ],
        ]);

        return ($iblock['RIGHTS_MODE'] ?? null);
    }
}
