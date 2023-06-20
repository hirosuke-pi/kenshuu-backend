<?php

PageController::sessionStart();

require_once __DIR__ .'/../templates/head.php';
require_once __DIR__ .'/../templates/header.php';
require_once __DIR__ .'/../templates/end.php';
require_once __DIR__ .'/../templates/footer.php';

require_once __DIR__ .'/../organisms/loginForm.php';

class Login {
    /**
     * ログインページをレンダリング
     *
     * @return void
     */
    public static function render(): void {
        ?>
            <?php Head::render('Flash News')?>
                <body>
                    <?php Header::render()?>
                    <div class="flex justify-center items-center flex-wrap">
                        <aside class="mx-2">
                            <image class="w-full max-w-xl" src="/img/login.jpg">
                        </aside>
                        <?php LoginForm::render() ?>
                    </div>
                    <?php Footer::render()?>
                </body>
            <?php End::render()?>
        <?php
    }
}
