<?php

namespace General;

use CIBlockResult;
use CIBlockSection;
use CModule;

/**
 * Класс по работе с разделами.
 */
class Sections
{
    public function __construct()
    {
        CModule::IncludeModule('iblock');
    }


    public function getSectionsWithBonus(): array {
        $sections = [];
        $sectionIdsWithBonus = [];
        $filter = ['IBLOCK_ID' => CATALOG_IBLOCK_ID];
        $sectionsResource = $this->fetchSections($filter);

        while ($section = $sectionsResource->GetNext()) {
            $sections[] = $section;
            if ($section['UF_BONUS_SYSTEM_ACTIVE'] === '1' && $section['UF_DOUBLE_BONUS'] === '1') {
                $sectionIdsWithBonus[] = $section['ID'];
            }
        }

        foreach ($sections as $section) {
            if (in_array($section['IBLOCK_SECTION_ID'], $sectionIdsWithBonus)) {
                $sectionIdsWithBonus[] = $section['ID'];
            }
        }

        return $sectionIdsWithBonus;
    }


    private function fetchSections(array $filter): CIBlockResult {
        return CIBlockSection::GetList([], $filter, false, ['UF_*']);
    }


}