<?php

class UserInfo {
    /**
     * ユーザー情報をレンダリング
     * 
     * @param UsersDTO $user ユーザー情報
     * @param int $postsCount 記事投稿数
     * @param string $title タイトル
     * @return void
     */
    public static function render(UsersDTO $user, int $postsCount, string $title): void {
        $isLogin = UserAuth::isLoginUser($user->id);
        $userUrl = '/user/index.php?id='. $user->id;

        $profileImageSrc = '/img/user.png';
        if ($user->profileImagePath !== '') {
            $profileImageSrc = '/img/users/'. $user->id .'.'. $user->profileImagePath;
        }

        ?>
            <section class="bg-gray-100 border border-gray-300 rounded-lg p-5">
                <h3 class="text-xl text-gray-800 font-bold border-b border-gray-400">
                    <i class="fa-solid fa-user"></i> <?=convertSpecialCharsToHtmlEntities($title) ?>
                </h3>
                <div class="mt-3 flex justify-center items-center flex-col">
                    <a class="flex flex-col justify-center items-center hover:underline" href="<?=$userUrl ?>">
                        <img class="w-20 h-20 rounded-full object-cover mb-1" src="<?=$profileImageSrc ?>" alt="user image">
                        <p class="text-xl font-bold text-gray-700 text-center">@<?=convertSpecialCharsToHtmlEntities($user->username) ?></p>
                    </a>
                    <p class="text-gray-600 mt-2">記事投稿数: <strong><?=convertSpecialCharsToHtmlEntities($postsCount) ?>件</strong></p>
                    <?php if ($isLogin): ?>
                        <a href="/user/settings.php" class="w-full border border-gray-400 hover:bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded text-center mt-3">
                            <i class="fa-solid fa-user-gear"></i> ユーザー設定
                        </a>
                    <?php endif; ?>
                </div>
            </section>
        <?php
    }
}
