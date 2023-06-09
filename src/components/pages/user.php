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
        $db = PDOFactory::getNewPDOInstance();

        if (!isset($_GET['id'])) {
            PageController::redirectWithStatus('/error.php', 'error', 'ユーザーIDが指定されていません。');
            return;
        }

        // ユーザーデータ取得
        $usersDao = new UsersDAO($db);
        $user = $usersDao->getUserById($_GET['id']);

        if (!isset($user)) {
            PageController::redirectWithStatus('/error.php', 'error', 'ユーザーが見つかりませんでした。');
            return;
        }

        ?>
            <?=Head::render('Flash News - @'. $user->username) ?>
                <body>
                    <?=Header::render() ?>
                    <section class="flex justify-center flex-wrap-reverse items-end">
                        <?=UserPosts::render($user->id, $user->username) ?>
                        <?=userDetail::render($user) ?>
                    </section>
                    <?=Footer::render() ?>
                </body>
            <?=End::render() ?>
        <?php
    }
}
