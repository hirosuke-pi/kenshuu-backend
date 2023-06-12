<?php

PageController::sessionStart();

require_once __DIR__ .'/../templates/head.php';
require_once __DIR__ .'/../templates/header.php';
require_once __DIR__ .'/../templates/end.php';
require_once __DIR__ .'/../templates/footer.php';

require_once __DIR__ .'/../organisms/userForm.php';

class Signup {
    /**
     * ログインページをレンダリング
     *
     * @return void
     */
    public static function render(): void {
        if (UserAuth::isLogin()) {
            PageController::redirectWithStatus('/', 'info', 'ログイン済みです。');
            return;
        }

        ?>
            <?php Head::render('Flash News - 新規登録')?>
                <body>
                    <?php Header::render()?>
                    <div class="flex flex-row justify-center items-center flex-wrap">
                        <?php UserForm::render() ?>
                        <aside class="mx-2">
                            <image class="w-full max-w-xl" src="/img/login.jpg">
                        </aside>
                    </div>
                    <?php Footer::render()?>
                </body>
            <?php End::render()?>
        <?php
    }
}
