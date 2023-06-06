<?php

PageController::sessionStart();

require_once __DIR__ .'/../templates/head.php';
require_once __DIR__ .'/../templates/header.php';
require_once __DIR__ .'/../templates/end.php';
require_once __DIR__ .'/../templates/footer.php';

require_once __DIR__ .'/../organisms/newsList.php';

class Home {
    /**
     * ホームページをレンダリング
     *
     * @return void
     */
    public static function render(): void {
        ?>
            <?=Head::render('Flash News')?>
                <body>
                    <?=Header::render()?>
                    <?=NewsList::render()?>
                    <?=Footer::render()?>
                </body>
            <?=End::render()?>
        <?php
    }
}
