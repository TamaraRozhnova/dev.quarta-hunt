<?php

namespace Helpers;

/**
 * Класс по работе с конвертацией ссылок на видео дял вставки на сайте.
 */
class VideoUrlHelper
{
    const YOUTUBE_VIDEO_EMBED_PATH = '//www.youtube.com/embed/';

    public static function convertVideoUrl(string $videoUrl): ?string
    {
        preg_match('/(?<=youtu\.be\/).*/', $videoUrl, $matches);
        return $matches[0] ? VideoUrlHelper::YOUTUBE_VIDEO_EMBED_PATH . $matches[0] : null;
    }
}