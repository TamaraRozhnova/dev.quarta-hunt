<?php

namespace General;

class Section
{
    const CATALOG_IBLOCK = 16;

    public function __construct()
    {
        \CModule::IncludeModule("iblock");

    }

    public static function getBonusSectionsArray(): array
    {
        $sections = \CIBlockSection::GetList([], ['IBLOCK_ID' => self::CATALOG_IBLOCK], false, ['UF_*']);

        $sids = [];
        $arSections = [];

        while ($s = $sections->GetNext()) {
            $arSections[] = $s;
            if ($s['UF_BONUS_SYSTEM_ACTIVE'] === '1') $sids[] = $s['ID'];
        }

        foreach ($arSections as $s) {
            if (in_array($s['IBLOCK_SECTION_ID'], $sids)) $sids[] = $s['ID'];
        }

        return $sids;
    }

    public static function getBonusDoubleSectionsArray(): array
    {
        $sections = \CIBlockSection::GetList([], ['IBLOCK_ID' => self::CATALOG_IBLOCK], false, ['UF_*']);

        $sids_db = [];
        $arSections = [];

        while ($s = $sections->GetNext()) {
            $arSections[] = $s;
            if ($s['UF_BONUS_SYSTEM_ACTIVE'] === '1' && $s['UF_DOUBLE_BONUS'] === '1') $sids_db[] = $s['ID'];
        }

        foreach ($arSections as $s) {
            if (in_array($s['IBLOCK_SECTION_ID'], $sids_db)) $sids_db[] = $s['ID'];
        }

        return $sids_db;
    }
}