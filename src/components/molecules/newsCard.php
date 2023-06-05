<?php

require_once __DIR__ .'/../atoms/badge.php';

class NewsCard {
    public static function render(PostsDTO $post): void {
        $newsLink = '/news/index.php?id='. $post->id;

        ?>
            <li class="m-3">
                <div class="max-w-sm rounded overflow-hidden shadow-md">
                    <a href="<?=$newsLink ?>" class="">
                        <img class="w-full" src="/img/news.jpg" alt="news image">
                    </a>
                    <div class="px-6 py-4">
                        <a href="<?=$newsLink ?>" class="hover:underline hover:text-gray-500">
                            <h3 class="font-bold text-xl mb-2"><i class="fa-solid fa-newspaper"></i> <?=$post->title ?></h3>
                        </a>
                        <p class="text-gray-700 text-base ellipsis-line-3">
                            <?=$post->body ?>
                        </p>
                        <p class="text-gray-700 text-base mt-4">
                            <i class="fa-regular fa-calendar"></i> <?=getDateTimeFormat($post->createdAt) ?>
                        </p>
                    </div>
                    <hr class="ml-3 mr-3 mt-1 mb-1">
                    <div class="px-6 pt-4 pb-2">
                        <?=Badge::render('テストバッジ')?>
                        <?=Badge::render('テストバッジ')?>
                        <?=Badge::render('テストバッジ')?>
                    </div>
                </div>
            </li>
        <?php
    }
}
