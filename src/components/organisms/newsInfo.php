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
     * @param PostsDTO $user ニュース投稿DTO
     * @param integer $postsCount 投稿数
     * @param string $mode 表示モードか、編集モードか (固定値: MODE_VIEW, MODE_EDIT, MODE_CREATE)
     * @return void
     */
    public static function render(UsersDTO $user, ?PostsDTO $post, int $postsCount, string $mode): void {
        ?>
            <aside class="w-full lg:w-80 m-3">
                <?=UserInfo::render(user: $user, postsCount: $postsCount, title: '投稿者', visibleSettingButton: false) ?>
                <section class="border border-gray-300 rounded-lg p-5 mt-3">
                    <h3 class="text-xl text-gray-800 font-bold border-b border-gray-400">
                        <i class="fa-solid fa-tags"></i> タグ
                    </h3>
                    <div class="mt-3 flex flex-wrap">
                        <?=TagCheckbox::render($mode === MODE_CREATE, $post->id ?? null) ?>
                    </div>
                </section>
                <section class="border border-gray-300 rounded-lg p-5 mt-3">
                    <h3 class="text-xl text-gray-800 font-bold border-b border-gray-400">
                        <i class="fa-solid fa-images"></i> 画像一覧
                    </h3>
                    <div class="mt-5">
                        <?php if ($mode === MODE_CREATE): ?>
                            <?php for($i = 0; $i < MAX_IMAGE_COUNT; $i++): ?>
                                <div class="mt-2 rounded-md overflow-hidden">
                                    <form id="imageForm">
                                        <?=SelectImage::render('image'. $i) ?>
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