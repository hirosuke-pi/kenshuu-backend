<?php

PageController::sessionStart();

require_once __DIR__ .'/../templates/head.php';
require_once __DIR__ .'/../templates/header.php';
require_once __DIR__ .'/../templates/end.php';
require_once __DIR__ .'/../templates/footer.php';

require_once __DIR__ .'/../organisms/newsList.php';
require_once __DIR__ .'/../organisms/newsSearch.php';

class Home {
    /**
     * ホームページをレンダリング
     *
     * @return void
     */
    public static function render(): void {
        $posts = isset($_GET['word']) ? PostsRepo::getPostsByWord($_GET['word']) : PostsRepo::getPosts();

        ?>
            <?php Head::render('Flash News')?>
                <body>
                    <?php Header::render()?>
                    <div class="flex flex-col justify-center items-center">
                        <div class="w-11/12">
                            <?php NewsSearch::render($posts)?>
                        </div>
                        <div class="w-11/12">
                            <?php NewsList::render($posts)?>
                        </div>
                    </div>
                    <?php Footer::render()?>
                </body>
            <?php End::render()?>
        <?php
    }
}
