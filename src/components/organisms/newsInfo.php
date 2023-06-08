<?php

require_once __DIR__ .'/../atoms/badge.php';
require_once __DIR__ .'/../molecules/userInfo.php';

class NewsInfo {
    /**
     * ニュース情報をレンダリング
     *
     * @param UsersDTO $user ユーザーDTO
     * @param integer $postsCount 投稿数
     * @return void
     */
    public static function render(UsersDTO $user, int $postsCount): void {
        ?>
            <aside class="w-full lg:w-80 m-3">
                <?php UserInfo::render(user: $user, postsCount: $postsCount, title: '投稿者', visibleSettingButton: false) ?>
                <section class="border border-gray-300 rounded-lg p-5 mt-3">
                    <h3 class="text-xl text-gray-800 font-bold border-b border-gray-400">
                    <i class="fa-solid fa-tags"></i> タグ
                    </h3>
                    <div class="mt-3 flex flex-wrap">
                        <?php Badge::render('テストバッジ1') ?>
                        <?php Badge::render('テストバッジ2') ?>
                        <?php Badge::render('テストバッジ3') ?>
                    </div>
                </section>
                <section class="border border-gray-300 rounded-lg p-5 mt-3">
                    <h3 class="text-xl text-gray-800 font-bold border-b border-gray-400">
                        <i class="fa-solid fa-images"></i> 画像一覧
                    </h3>
                    <div class="mt-5">
                        <img class="w-full rounded-lg my-2" src="/img/news.jpg" alt="news image">
                        <img class="w-full rounded-lg my-2" src="/img/news.jpg" alt="news image">
                        <img class="w-full rounded-lg my-2" src="/img/news.jpg" alt="news image">
                    </div>
                </section>
            </aside>
        <?php
    }
}
