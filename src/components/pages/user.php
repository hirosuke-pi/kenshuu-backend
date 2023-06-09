<?php

PageController::sessionStart();

require_once __DIR__ .'/../templates/head.php';
require_once __DIR__ .'/../templates/header.php';
require_once __DIR__ .'/../templates/end.php';
require_once __DIR__ .'/../templates/footer.php';

require_once __DIR__ .'/../organisms/userPosts.php';
require_once __DIR__ .'/../organisms/userDetail.php';

class User {
    /**
     * ユーザーページをレンダリング
     *
     * @return void
     */
    public static function render(): void {
        if (!isset($_GET['id'])) {
            PageController::redirectWithStatus('/error.php', 'error', 'ユーザーIDが指定されていません。');
            return;
        }

        // ユーザーデータ取得
        $user = UsersRepo::getUserById($_GET['id']);
        if (!isset($user)) {
            PageController::redirectWithStatus('/error.php', 'error', 'ユーザーが見つかりませんでした。');
            return;
        }

        ?>
            <?php Head::render('Flash News - @'. $user->username) ?>
                <body>
                    <?php Header::render() ?>
                    <section class="flex justify-center flex-wrap-reverse items-end">
                        <?php UserPosts::render($user->id, $user->username) ?>
                        <?php userDetail::render($user) ?>
                    </section>
                    <?php Footer::render() ?>
                </body>
            <?php End::render() ?>
        <?php
    }
}
