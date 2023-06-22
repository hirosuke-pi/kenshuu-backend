<?php

PageController::sessionStart();

require_once __DIR__ .'/../templates/head.php';
require_once __DIR__ .'/../templates/header.php';
require_once __DIR__ .'/../templates/end.php';
require_once __DIR__ .'/../templates/footer.php';

require_once __DIR__ .'/../organisms/userDetail.php';
require_once __DIR__ .'/../organisms/userForm.php';

class UserSettings {
    /**
     * ユーザーページをレンダリング
     * @return void
     */
    public static function render(): void {
        $userId = UserAuth::getLoginUserId();
        if (is_null($userId)) {
            PageController::redirectWithStatus('/login.php', 'error', 'ログインしてください。');
            return;
        }

        // ユーザーデータ取得
        $db = PDOFactory::getNewPDOInstance();
        $usersDao = new UsersDAO($db);
        $user = $usersDao->getUserById($userId);

        ?>
            <?php Head::render('Flash News - @'. $user->username) ?>
                <body>
                    <?php Header::render() ?>
                    <section class="flex justify-center flex-wrap-reverse items-end">
                        <?php UserForm::render($user) ?>
                        <?php UserDetail::render($user) ?>
                    </section>
                    <?php Footer::render() ?>
                </body>
            <?php End::render() ?>
        <?php
    }
}
