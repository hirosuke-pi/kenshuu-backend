<?php

PageController::sessionStart();

require_once __DIR__ .'/../templates/head.php';
require_once __DIR__ .'/../templates/header.php';
require_once __DIR__ .'/../templates/end.php';
require_once __DIR__ .'/../templates/footer.php';

require_once __DIR__ .'/../molecules/AlertSession.php';

class ErrorPage {
    /**
     * エラーページをレンダリング
     *
     * @return void
     */
    public static function render(): void {
        if (!PageController::hasRedirectData()) {
            PageController::redirect('/');
        }

        ?>
            <?php Head::render('Flash News - エラー')?>
                <body>
                    <?php Header::render()?>
                    <main class="flex justify-center flex-col items-center mx-3">
                        <img class="h-60 my-5" src="https://3.bp.blogspot.com/-f2csyxp_K2o/VuKEBEj7NjI/AAAAAAAA4w4/jVcA_kX6sbcXu3O5R5muNVOlN1DdyW2kA/s800/pet_angel_cat.png" />
                        <?php AlertSession::render(false) ?>
                        <a href="/" class="mt-5 bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded ">
                            <i class="fa-solid fa-arrow-left"></i> ホームへ戻る
                        </a>
                    </main>
                    <?php Footer::render()?>
                </body>
            <?php End::render()?>
        <?php
    }
}

?>
