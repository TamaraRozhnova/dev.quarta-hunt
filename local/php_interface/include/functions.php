<?php

function getRootProductSection($iblockId, $sectionId) {
    $arSections = [];
    while($sectionId) {
        if ($arSection = \Bitrix\Iblock\SectionTable::getList([
            'filter' => ['IBLOCK_ID' => $iblockId, 'ID' => $sectionId],
            'select' => ['ID', 'IBLOCK_SECTION_ID', 'CODE']
        ])->fetch()) {
            $arSections[] = $arSection;
        }
        $sectionId = $arSection['IBLOCK_SECTION_ID'];
    }
    $arSections = array_reverse($arSections);
    return $arSections;
}