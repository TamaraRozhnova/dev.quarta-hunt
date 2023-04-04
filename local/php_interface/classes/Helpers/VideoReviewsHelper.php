<?php

namespace Helpers;

use CFile;
use CIBlockElement;
use General\Section;

/**
 * Класс по работе с видео-обзорами.
 */
class VideoReviewsHelper
{
    const VIDEO_REVIEWS_IBLOCK_ID = 12;

    const YOUTUBE_VIDEO_EMBED_PATH = '//www.youtube.com/embed/';


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
                preg_match('/(?<=youtu\.be\/).*/', $videoUrl, $matches);
                $videoSrc = $matches[0] ? VideoReviewsHelper::YOUTUBE_VIDEO_EMBED_PATH . $matches[0] : null;
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