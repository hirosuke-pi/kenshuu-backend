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
        $db = PDOFactory::getNewPDOInstance();
        $postsDao = new PostsDAO($db);

        $posts = $postsDao->getPosts();

        ?>
            <?=Head::render('Flash News')?>
                <body>
                    <?=Header::render()?>
                    <div class="flex flex-col justify-center items-center">
                        <div class="w-11/12">
                            <?=NewsSearch::render($posts)?>
                        </div>
                        <div class="w-11/12">
                            <?=NewsList::render($posts)?>
                        </div>
                    </div>
                    <?=Footer::render()?>
                </body>
            <?=End::render()?>
        <?php
    }
}
