<?php

require_once __DIR__ .'/../atoms/badge.php';
require_once __DIR__ .'/../atoms/selectImage.php';
require_once __DIR__ .'/../molecules/userInfo.php';
require_once __DIR__ .'/../molecules/tagCheckbox.php';

class NewsInfo {
    /**
     * ニュース情報をレンダリング
     *
     * @param UsersDTO $user ユーザーDTO
     * @param ?PostsDTO $post ニュース投稿DTO
     * @param integer $postsCount 投稿数
     * @param NewsMode $mode ニュース表示モード
     * @return void
     */
    public static function render(UsersDTO $user, ?PostsDTO $post, NewsMode $mode): void {
        $isCreateMode = $mode === NewsMode::CREATE;
        $postsCount = PostsRepo::getPostsCountByUserId($user->id);
        $tags = match($mode) {
            NewsMode::CREATE => TagsRepo::getTags(),
            default => TagsRepo::getTagsByPostId($post->id)
        };

        ?>
            <aside class="w-full lg:w-80 m-3">
                <?php UserInfo::render($user, $postsCount, '投稿者') ?>
                <section class="border border-gray-300 rounded-lg p-5 mt-3">
                    <h3 class="text-xl text-gray-800 font-bold border-b border-gray-400">
                        <i class="fa-solid fa-tags"></i> タグ
                    </h3>
                    <div class="mt-3 flex flex-wrap">
                        <?php TagCheckbox::render($tags, $isCreateMode) ?>
                    </div>
                </section>
                <section class="border border-gray-300 rounded-lg p-5 mt-3">
                    <h3 class="text-xl text-gray-800 font-bold border-b border-gray-400">
                        <i class="fa-solid fa-images"></i> 画像一覧
                    </h3>
                    <div class="mt-5">
                        <?php if ($isCreateMode): ?>
                            <?php for($i = 0; $i < MAX_IMAGE_COUNT; $i++): ?>
                                <div class="mt-2 rounded-md overflow-hidden">
                                    <form id="imageForm">
                                        <?php SelectImage::render('image'. $i) ?>
                                    </form>
                                </div>
                            <?php endfor; ?>
                        <?php else: ?>
                            <?php $imagesSrc = ImagesRepo::getImagesSrcByPostId($post->id); ?>
                            <?php foreach($imagesSrc as $imageSrc): ?>
                                <div class="mt-2 rounded-md overflow-hidden">
                                    <img class="w-full" src="<?=$imageSrc?>" alt="news image">
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </section>
            </aside>
        <?php
    }
}
