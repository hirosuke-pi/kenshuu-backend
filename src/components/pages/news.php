<?php

PageController::sessionStart();

require_once __DIR__ .'/../templates/head.php';
require_once __DIR__ .'/../templates/header.php';
require_once __DIR__ .'/../templates/end.php';
require_once __DIR__ .'/../templates/footer.php';

require_once __DIR__ .'/../organisms/newsDetail.php';
require_once __DIR__ .'/../organisms/userInfo.php';

class News {
    /**
     * ニュース詳細ページをレンダリング
     *
     * @return void
     */
    public static function render(string $mode): void {
        $db = PDOFactory::getNewPDOInstance();

        // 投稿データ取得
        $postsDao = new PostsDAO($db);
        $post = $postsDao->getPostById($_GET['id']);
        if (is_null($post)) {
            PageController::redirect('/error.php', ['message' => '投稿が見つかりませんでした']);
        }
    
        $usersDao = new UsersDAO($db);
        $user = $usersDao->getUserById($post->userId);
        $postsCount = $postsDao->getPostsCountByUserId($post->userId);
    
        ?>
            <?php Head::render('Flash News - '. $post->title) ?>
                <body>
                    <?php Header::render() ?>
                    <section class="flex justify-center flex-wrap items-start">
                        <?=NewsDetail::render($post, $mode) ?>
                        <?=UserInfo::render($user->username, $postsCount) ?>
                    </section>
                    <?php Footer::render() ?>
                </body>
            <?php End::render() ?>
        <?php
    }
}
