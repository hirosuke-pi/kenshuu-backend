<?php

require_once __DIR__ .'/../molecules/userInfo.php';

class UserDetail {
    /**
     * ユーザー詳細をレンダリング
     *
     * @param UsersDTO $user ユーザーDTO
     * @return void
     */
    public static function render(UsersDTO $user) {
        $postsCount = PostsRepo::getPostsCountByUserId($user->id);

        ?>
            <aside class="w-full lg:w-80 m-3">
            <?=UserInfo::render(user: $user, postsCount: $postsCount, title: 'ユーザー情報', visibleSettingButton: true) ?>
                <section class="border border-gray-300 rounded-lg p-5 mt-3">
                    <h3 class="text-xl text-gray-800 font-bold border-b border-gray-400">
                        <i class="fa-solid fa-newspaper"></i> ニュース
                    </h3>
                    <div class="mt-3 flex flex-col">
                        <a href="/news/post.php" class="w-full bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded mr-3 text-center mt-3">
                            <i class="fa-solid fa-pen-to-square"></i> 新規作成
                        </a>
                    </div>
                </section>
            </aside>
        <?php
    }
}
