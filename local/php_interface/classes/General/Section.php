<?php

namespace General;

class Section
{

    public function __construct()
    {
        \CModule::IncludeModule("iblock");

    }

    public static function getBonusSectionsArray(): array
    {
        $sections = \CIBlockSection::GetList([], ['IBLOCK_ID' => CATALOG_IBLOCK_ID], false, ['UF_*']);

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
        $sections = \CIBlockSection::GetList([], ['IBLOCK_ID' => CATALOG_IBLOCK_ID], false, ['UF_*']);

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


    /**
     * @return array|false - возвращает массив свойств раздела или false, если не найден
     */
    public static function getSection(int $sectionId, string $sectionUrlTemplate) {
        $sectionResource = \CIBlockSection::GetByID($sectionId);
        $sectionResource->SetUrlTemplates(false, $sectionUrlTemplate);
        if ($section = $sectionResource->GetNext()) {
            return $section;
        }

        return false;
    }

    public static function getSubsections(int $sectionId, string $sectionUrlTemplate): array {
        $filter = [
            'IBLOCK_ID' => CATALOG_IBLOCK_ID,
            'SECTION_ID' => $sectionId,
            'ACTIVE' => 'Y'
        ];

        $subsections = [];
        $subsectionsResource = \CIBlockSection::GetList([], $filter);
        $subsectionsResource->SetUrlTemplates(false, $sectionUrlTemplate);
        while ($subsection = $subsectionsResource->GetNext()) {
            $subsections[] = $subsection;
        }

        return $subsections;
    }
}