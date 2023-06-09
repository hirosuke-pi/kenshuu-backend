<?php

require_once __DIR__ .'/../templates/head.php';
require_once __DIR__ .'/../templates/header.php';
require_once __DIR__ .'/../templates/end.php';
require_once __DIR__ .'/../templates/footer.php';

class ErrorPage {
    public static function render(): void {
        $session = PageController::getRedirectData();
        if (!isset($session) || !isset($session['message'])) {
            PageController::redirect('/index.php');
        }

        ?>
            <?php Head::render('Flash News - エラー') ?>
                <body>
                    <?php Header::render() ?>
                    <main class="flex justify-center flex-col items-center">
                        <h2 class="text-2xl">エラー: <?=convertSpecialCharsToHtmlEntities($session['message']) ?></h2>
                        <a href="/" class="mt-5 bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded ">
                            <i class="fa-solid fa-arrow-left"></i> ホームへ戻る
                        </a>
                    </main>
                    <?php Footer::render() ?>
                </body>
            <?php End::render() ?>
        <?php
    }
}

?>
