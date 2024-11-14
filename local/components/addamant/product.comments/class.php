<?php

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bitrix\Main\UserTable;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Errorable;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Error;
use Bitrix\Main\Application;

class ProductCommentsComponent extends CBitrixComponent implements Controllerable, Errorable
{
    private const COMMENT_CREATE_DATE_TIME_CURRENT_YEAR_TEMPLATE = 'd F H:i';
    private const COMMENT_CREATE_DATE_TIME_NO_CURRENT_YEAR_TEMPLATE = 'd F Y г. H:i';
    private const COMMENT_TEXT_AREA_MAX = 250;
    private const COMMENT_TEXT_AREA_MIN = 20;

    /** @var ErrorCollection $errorCollection */
    protected ErrorCollection $errorCollection;

    /** @var CurrentUser $currentUser */
    private CurrentUser $currentUser;

    /** @var array $product */
    private array $product;

    /** @var int $blogId */
    private int $blogId;

    /** @var int $blogPostId */
    private int $blogPostId;

    /**
     * @param CBitrixComponent|null $component
     *
     * @throws ModuleNotIncludeException
     * @throws LoaderException
     */
    public function __construct(CBitrixComponent $component = null)
    {
        parent::__construct($component);
        Loader::includeModule('addamant.thanks');
        Loader::includeModule('blog');
        Loader::includeModule('iblock');
        $this->currentUser = CurrentUser::get();
    }

    /**
     * @param $arParams
     *
     * @return array
     */
    public function onPrepareComponentParams($arParams): array
    {
        $arParams['BLOG_TITLE'] = trim($arParams['BLOG_TITLE'] ?? '');
        $arParams['BLOG_DESCRIPTION'] = trim($arParams['BLOG_DESCRIPTION'] ?? '');
        $arParams['BLOG_URL'] = trim($arParams['BLOG_URL'] ?? '');
        $arParams['ELEMENT_ID'] = (int)($arParams['ELEMENT_ID'] ?? 0);
        $arParams['IBLOCK_ID'] = (int)($arParams['IBLOCK_ID'] ?? 0);
        $arParams['BLOG_GROUP_ID'] = (int)($arParams['BLOG_GROUP_ID'] ?? 0);
        $arParams['ELEMENT_COUNT'] = (int)($arParams['ELEMENT_COUNT'] ?? 10);

        $this->errorCollection = new ErrorCollection();

        return $arParams;
    }

    /**
     * @return void
     * @throws ArgumentException
     * @throws ObjectException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function executeComponent(): void
    {
        if (empty($this->arParams['BLOG_URL'])) {
            ShowError(Loc::getMessage('NO_BLOG_URL'));
            return;
        }

        if (!$this->arParams['ELEMENT_ID']) {
            ShowError(Loc::getMessage('ELEMENT_ID'));
            return;
        }

        if (!$this->arParams['IBLOCK_ID']) {
            ShowError(Loc::getMessage('NO_IBLOCK_ID'));
            return;
        }

        if (!$this->arParams['BLOG_GROUP_ID']) {
            ShowError(Loc::getMessage('NO_BLOG_GROUP_ID'));
            return;
        }

        $this->arResult['COMMENTS'] = $this->getComments();
        $this->arResult['CURRENT_USER'] = &$this->arResult['USERS'][$this->currentUser->getId()];

        $this->arResult['JS_DATA'] =
            [
                'COMMENT_TEXT_AREA_MAX' => self::COMMENT_TEXT_AREA_MAX,
                'COMMENT_TEXT_AREA_MIN' => self::COMMENT_TEXT_AREA_MIN,
                'COMMENTS_COUNT' => count($this->arResult['COMMENTS']),
            ];

        $this->IncludeComponentTemplate();
    }

    /**
     * @param int $currentCommentCount
     *
     * @return array
     */
    public function moreCommentAction(int $currentCommentCount): array
    {
        try {
            $this->arParams['ELEMENT_COUNT'] += $currentCommentCount;

            ob_start();
            $this->executeComponent();
            $html = ob_get_clean();

            $productCommentsCount = (int)$this->getProduct()['PROPERTY_BLOG_COMMENTS_CNT_VALUE'];

            return
                [
                    'RESULT' => Loc::getMessage('SUCCESS_GET_COMMENTS'),
                    'HTML' => $html,
                    'COMMENTS_COUNT' => $productCommentsCount,
                ];
        } catch (Throwable $throwable) {
            $this->errorCollection->add([new Error($throwable->getMessage())]);
            return ['RESULT' => Loc::getMessage('ERROR_GET_COMMENTS')];
        }
    }

    /**
     * @param string $comment
     *
     * @return array
     */
    public function addCommentAction(string $comment, int $currentCommentCount): array
    {
        try {
            $this->arParams['ELEMENT_COUNT'] = $currentCommentCount + 1;

            $blogPostId = $this->getBlogPostId();

            if (!$blogPostId) {
                $this->errorCollection->add([new Error(Loc::getMessage('ERROR_ADD_BLOG_POST'))]);
                return ['RESULT' => Loc::getMessage('ERROR_ADD_BLOG_POST')];
            }

            $commentId = CBlogComment::Add([
                'BLOG_ID' => $this->getBlogId(),
                'POST_ID' => $blogPostId,
                'AUTHOR_ID' => $this->currentUser->getId(),
                'POST_TEXT' => $comment,
                'PUBLISH_STATUS' => 'P',
                'DATE_CREATE' => new DateTime(),
                'PATH' => '',
            ]);

            if (!$commentId) {
                $this->errorCollection->add([new Error(Loc::getMessage('ERROR_ADD_COMMENT'))]);
                return ['RESULT' => Loc::getMessage('ERROR_ADD_COMMENT')];
            }

            ob_start();
            $this->executeComponent();
            $html = ob_get_clean();

            $productCommentsCount = (int)$this->getProduct()['PROPERTY_BLOG_COMMENTS_CNT_VALUE'] + 1;

            CIBlockElement::SetPropertyValuesEx(
                $this->arParams['ELEMENT_ID'],
                $this->arParams['IBLOCK_ID'],
                ['BLOG_COMMENTS_CNT' => $productCommentsCount],
            );

            $taggedCache = Application::getInstance()->getTaggedCache();
            $taggedCache->clearByTag('iblock_id_' . $this->arParams['IBLOCK_ID']);

            return
                [
                    'RESULT' => Loc::getMessage('SUCCESS_ADD_COMMENT'),
                    'HTML' => $html,
                    'COMMENTS_COUNT' => $productCommentsCount,
                ];
        } catch (Throwable $throwable) {
            $this->errorCollection->add([new Error($throwable->getMessage())]);
            return ['RESULT' => Loc::getMessage('ERROR_ADD_COMMENT')];
        }
    }

    /**
     * @param int $commentId
     *
     * @return array
     */
    public function likeCommentAction(int $commentId): array
    {
        $commentRating = $this->getRating([$commentId]);
        $userReaction = $commentRating[$commentId]['USER_REACTION_LIST'][$this->currentUser->getId()];
        $isLiked = !$commentRating || $userReaction !== 'like';

        try {
            if ($isLiked) {
                $currentUserIp = CBlogUser::GetUserIP();
                $userData = CRatings::AddRatingVote([
                    'ENTITY_TYPE_ID' => 'BLOG_COMMENT',
                    'ENTITY_ID' => $commentId,
                    'VALUE' => 1,
                    'USER_ID' => $this->currentUser->getId(),
                    'USER_IP' => reset($currentUserIp),
                ]);
            } else {
                $userData = CRatings::CancelRatingVote([
                    'ENTITY_TYPE_ID' => 'BLOG_COMMENT',
                    'ENTITY_ID' => $commentId,
                    'USER_ID' => $this->currentUser->getId(),
                ]);
            }

            if (!$userData) {
                $errorText = $isLiked ? Loc::getMessage('ERROR_SET_LIKE') : Loc::getMessage('ERROR_CANSEL_LIKE');
                $this->errorCollection->add([new Error($errorText)]);
                return ['RESULT' => $errorText];
            }

            $resultText = $isLiked ? Loc::getMessage('SUCCESS_SET_LIKE') : Loc::getMessage('SUCCESS_CANSEL_LIKE');
            $countLiked = (int)$commentRating[$commentId]['TOTAL_POSITIVE_VOTES'];
            $countLiked = $isLiked ? $countLiked + 1 : $countLiked - 1;

            return
                [
                    'RESULT' => $resultText,
                    'IS_LIKED' => $isLiked,
                    'COUNT_LIKED' => $countLiked,
                ];
        } catch (Throwable $throwable) {
            $this->errorCollection->add([new Error($throwable->getMessage())]);
            return ['RESULT' => Loc::getMessage('ERROR_SET_LIKE')];
        }
    }

    /**
     * @param int $commentId
     *
     * @return array
     */
    public function deleteCommentAction(int $commentId, int $currentCommentCount): array
    {
        try {
            $elementCount = $currentCommentCount - 1;
            $elementCount = ($elementCount > 0) ? $elementCount : $this->arParams['ELEMENT_COUNT'];
            $this->arParams['ELEMENT_COUNT'] = $elementCount;

            $deleteBlogResult = CBlogComment::Delete($commentId);

            if (!$deleteBlogResult || !$deleteBlogResult->result) {
                $this->errorCollection->add([new Error(Loc::getMessage('ERROR_DELETE_COMMENT'))]);
                return ['RESULT' => Loc::getMessage('ERROR_DELETE_COMMENT')];
            }

            ob_start();
            $this->executeComponent();
            $html = ob_get_clean();

            $productCommentsCount = (int)$this->getProduct()['PROPERTY_BLOG_COMMENTS_CNT_VALUE'] - 1;

            CIBlockElement::SetPropertyValuesEx(
                $this->arParams['ELEMENT_ID'],
                $this->arParams['IBLOCK_ID'],
                ['BLOG_COMMENTS_CNT' => $productCommentsCount],
            );

            return
                [
                    'RESULT' => Loc::getMessage('SUCCESS_DELETE_COMMENT'),
                    'HTML' => $html,
                    'COMMENTS_COUNT' => $productCommentsCount
                ];
        } catch (Throwable $throwable) {
            $this->errorCollection->add([new Error($throwable->getMessage())]);
            return ['RESULT' => Loc::getMessage('ERROR_DELETE_COMMENT')];
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
                'BLOG_TITLE',
                'BLOG_DESCRIPTION',
                'BLOG_URL',
                'ELEMENT_ID',
                'IBLOCK_ID',
                'CACHE_TIME',
                'BLOG_GROUP_ID',
                'ELEMENT_COUNT',
            ];
    }

    /**
     * @return array
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws ObjectException
     */
    private function getComments(): array
    {
        $commentQuery = CBlogComment::GetList(
            [
                'DATE_CREATE' => 'DESC',
            ],
            [
                'POST_ID' => $this->getBlogPostId(),
                'PUBLISH_STATUS' => 'P',
            ],
            false,
            [
                'nPageSize' => $this->arParams['ELEMENT_COUNT'],
            ],
            [
                'ID',
                'AUTHOR_ID',
                'POST_TEXT',
                'DATE_CREATE',
            ],
        );
        $comments = [];
        $usersId = [];

        while ($comment = $commentQuery->fetch()) {
            $dateTimeCreated = new DateTime($comment['DATE_CREATE']);
            $dateTimeCreatedFormat = self::COMMENT_CREATE_DATE_TIME_CURRENT_YEAR_TEMPLATE;

            if ($dateTimeCreated->format('Y') !== (new DateTime())->format('Y')) {
                $dateTimeCreatedFormat = self::COMMENT_CREATE_DATE_TIME_NO_CURRENT_YEAR_TEMPLATE;
            }

            $comment['DATE_CREATE_FORMATTED'] = mb_strtolower(
                FormatDate($dateTimeCreatedFormat, $dateTimeCreated->getTimestamp()),
            );

            $comments[$comment['ID']] = $comment;

            $usersId[$comment['AUTHOR_ID']] = $comment['AUTHOR_ID'];
        }

        $this->arResult['USERS'] = $this->getUsers($usersId);
        $this->arResult['USER_IDS_WITH_COMMENTS'] = $usersId;
        $this->arResult['RATING_COMMENTS'] = $this->getRating(array_keys($comments));
        $this->arResult['COMMENTS_COUNT'] = $commentQuery->NavRecordCount;

        return $comments;
    }

    /**
     * @param array $commentsId
     *
     * @return array
     */
    private function getRating(array $commentsId): array
    {
        return CRatings::GetRatingVoteResult('BLOG_COMMENT', $commentsId);
    }

    /**
     * @param array $usersId
     *
     * @return array
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    private function getUsers(array $usersId): array
    {
        $userQuery = UserTable::getList([
            'filter' => ['ID' => array_merge($usersId, [$this->currentUser->getId()])],
            'select' => ['ID', 'NAME', 'LAST_NAME', 'PERSONAL_PHOTO'],
        ]);
        $users = [];

        while ($user = $userQuery->fetch()) {
            $userImage = CFile::ResizeImageGet(
                $user['PERSONAL_PHOTO'],
                ['width' => 40, 'height' => 40],
                BX_RESIZE_IMAGE_EXACT,
            );

            $users[$user['ID']] =
                [
                    'ID' => $user['ID'],
                    'FIO' => $this->createFullName(
                        $user['LAST_NAME'] ?? '',
                        $user['NAME'] ?? '',
                        '',
                    ),
                    'PERSONAL_PHOTO_SRC' => $userImage['src'],
                ];
        }

        return $users;
    }

    private function createFullName(string $lastName, string $firstName, string $middleName): string
    {
        $fullNameParts = array_filter([$lastName, $firstName, $middleName]);
        return implode(' ', $fullNameParts);
    }

    /**
     * @return int
     */
    private function getBlogPostId(): int
    {
        if (isset($this->blogPostId)) {
            return $this->blogPostId;
        }

        $product = $this->getProduct();
        $blogPostId = (int)$product['PROPERTY_BLOG_POST_ID_VALUE'];

        if (!$blogPostId) {
            $blogPostId = $this->addBlogPost();
        }

        $this->blogPostId = $blogPostId;

        return $this->blogPostId;
    }

    /**
     * @return int
     */
    private function addBlogPost(): int
    {
        $blogId = $this->getBlogId();
        $this->blogId = $blogId;

        if (!$blogId) {
            return 0;
        }

        $product = $this->getProduct();

        $blogPostId = CBlogPost::Add([
            'TITLE' => $product['NAME'],
            'BLOG_ID' => $blogId,
            'AUTHOR_ID' => $this->currentUser->getId(),
            'DETAIL_TEXT' => $product['PREVIEW_TEXT'] ? $product['PREVIEW_TEXT'] : 'Нет превью текста',
        ]);

        $this->blogPostId = (int)$blogPostId;

        CIBlockElement::SetPropertyValuesEx(
            $this->arParams['ELEMENT_ID'],
            $this->arParams['IBLOCK_ID'],
            ['BLOG_POST_ID' => $this->blogPostId],
        );

        return $this->blogPostId;
    }

    /**
     * @return int
     */
    private function getBlogId(): int
    {
        if (isset($this->blogId)) {
            return $this->blogId;
        }

        $blog = CBlog::GetList(
            [],
            [
                'URL' => $this->arParams['BLOG_URL'],
            ],
            false,
            false,
            [
                'ID',
            ],
        )->fetch();

        $blogId = (int)$blog['ID'];

        if ($blogId) {
            $this->blogId = $blogId;
            return $blogId;
        }

        return $this->addBlog();
    }

    /**
     * @return int
     */
    private function addBlog(): int
    {
        $blogId = CBlog::Add([
            'NAME' => $this->arParams['BLOG_TITLE'] ?: Loc::getMessage('BLOG_TITLE_DEFAULT'),
            'DESCRIPTION' => $this->arParams['BLOG_DESCRIPTION'] ?: Loc::getMessage('BLOG_DESCRIPTION_DEFAULT'),
            'URL' => $this->arParams['BLOG_URL'],
            'GROUP_ID' => $this->arParams['BLOG_GROUP_ID'],
            'DATE_CREATE' => new DateTime(),
            'OWNER_ID' => $this->currentUser->getId(),
        ]);

        $this->blogId = (int)$blogId;

        return $this->blogId;
    }

    /**
     * @return array
     */
    private function getProduct(): array
    {
        if (isset($this->product)) {
            return $this->product;
        }

        $product = CIBlockElement::GetList(
            [],
            ['IBLOCK_ID' => $this->arParams['IBLOCK_ID'], 'ID' => $this->arParams['ELEMENT_ID']],
            false,
            false,
            ['ID', 'NAME', 'PREVIEW_TEXT', 'PROPERTY_BLOG_POST_ID', 'PROPERTY_BLOG_COMMENTS_CNT'],
        )->fetch();

        $this->product = $product ?: [];

        return $this->product;
    }
}
