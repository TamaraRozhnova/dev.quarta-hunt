<?php

namespace Helpers;

use CFile;
use CIBlockElement;

/**
 * Класс по работе с видео-обзорами.
 */
class VideoReviewsHelper
{
    const VIDEO_REVIEWS_IBLOCK_ID = 12;

    public static function getVideoReviews(int $sectionId): array
    {
        $filter = ['IBLOCK_ID' => VideoReviewsHelper::VIDEO_REVIEWS_IBLOCK_ID, 'PROPERTY_SECTION_ID' => $sectionId];
        $videoReviewsResource = CIBlockElement::GetList([], $filter, false, ['nTopCount' => 1]);
        $result = [];

        while ($videoReview = $videoReviewsResource->GetNextElement()) {
            $fields = $videoReview->GetFields();
            $props = $videoReview->GetProperties();

            $previewImageIds = $props['VIDEO_PREVIEW_IMAGES']['VALUE'];
            $videoUrls = $props['VIDEO_LINKS']['VALUE'];
            $result['NAME'] = $fields['NAME'];

            foreach ($videoUrls as $key => $videoUrl) {
                $videoSrc = VideoUrlHelper::convertVideoUrl($videoUrl);
                if (!$videoSrc) {
                    continue;
                }
                $result['LIST'][] = [
                    'PREVIEW_IMAGE' => CFile::GetPath($previewImageIds[$key]),
                    'VIDEO_SRC' => $videoSrc
                ];
            }
        }

        return $result;
    }
}