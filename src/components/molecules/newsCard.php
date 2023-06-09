<?php

require_once __DIR__ .'/../atoms/badge.php';
require_once __DIR__ .'/tagCheckbox.php';

class NewsCard {
    /**
     * ニュースのカードをレンダリング
     *
     * @param PostsDTO $post ニュースのデータ
     * @param CardSize $mode カードの表示モード
     * @return void
     */
    public static function render(PostsDTO $post, CardSize $mode): void {
        $newsLink = '/news/index.php?id='. $post->id;
        $cardSize = $mode === CardSize::SMALL ? 'w-96' : 'w-full';
        $thumbnailPath = ImagesRepo::getThumbnailSrcByPostId($post->id);
        $tags = TagsRepo::getTagsByPostId($post->id);

        ?>
            <li class="m-3 <?=$cardSize ?>">
                <div class="rounded overflow-hidden border border-gray-300">
                    <a href="<?=$newsLink ?>" class="">
                        <img class="w-full" src="<?=$thumbnailPath ?>" alt="news image">
                    </a>
                    <div class="px-6 py-4">
                        <a href="<?=$newsLink ?>" class="hover:underline hover:text-gray-500">
                            <h3 class="font-bold text-xl mb-2"><i class="fa-solid fa-newspaper"></i> <?=convertSpecialCharsToHtmlEntities($post->title) ?></h3>
                        </a>
                        <p class="text-gray-700 text-base ellipsis-line-3">
                            <?=convertSpecialCharsToHtmlEntities($post->body) ?>
                        </p>
                        <?php if (isset($post->updatedAt)): ?>
                            <p class="text-gray-700 text-base mt-4">
                                <i class="fa-solid fa-pen-to-square"></i> <?=getDateTimeFormat($post->updatedAt) ?>
                            </p>
                        <?php else: ?>
                            <p class="text-gray-700 text-base mt-4">
                                <i class="fa-regular fa-calendar"></i> <?=getDateTimeFormat($post->createdAt) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <hr class="ml-3 mr-3 mt-1 mb-1">
                    <div class="px-6 pt-4 pb-2">
                        <?php TagCheckbox::render($tags, false) ?>
                    </div>
                </div>
            </li>
        <?php
    }
}
