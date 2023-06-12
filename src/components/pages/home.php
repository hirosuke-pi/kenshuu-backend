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
        PDOFactory::getNewPDOInstance();
        ?>
            <?php Head::render('Flash News')?>
                <body>
                    <?php Header::render()?>
                    <?php NewsList::render()?>
                    <?php Footer::render()?>
                </body>
            <?php End::render()?>
        <?php
    }
}
