<?php

PageController::sessionStart();

require_once __DIR__ .'/../templates/head.php';
require_once __DIR__ .'/../templates/header.php';
require_once __DIR__ .'/../templates/end.php';
require_once __DIR__ .'/../templates/footer.php';

require_once __DIR__ .'/../organisms/newsDetail.php';
require_once __DIR__ .'/../organisms/newsInfo.php';

class News {
    /**
     * ニュース詳細ページをレンダリング
     *
     * @return void
     */
    public static function render(string $mode): void {
        $db = PDOFactory::getNewPDOInstance();

        $usersDao = new UsersDAO($db);
        $user = $usersDao->getUserByEmail('test@test.com');

        $postsDao = new PostsDAO($db);
        $postsCount = $postsDao->getPostsCountByUserId($user->id);

        $title = 'Flash News - 新規作成';
        $post = null;
        if (in_array($mode, [MODE_VIEW, MODE_EDIT])) {
            // 編集・閲覧モード
            // 投稿データ取得
            $post = $postsDao->getPostById($_GET['id']);
            if (!isset($post)) {
                PageController::redirect('/error.php', ['message' => '投稿が見つかりませんでした。']);
            }
            $title = 'Flash News - '. $post->title;
        }
    
        ?>
            <?=Head::render('Flash News - '. $title) ?>
                <body>
                    <?=Header::render() ?>
                    <section class="flex justify-center flex-wrap items-start">
                        <?=NewsDetail::render($user, $post, $mode) ?>
                        <?=NewsInfo::render($user, $postsCount) ?>
                    </section>
                    <?=Footer::render() ?>
                </body>
            <?=End::render() ?>
        <?php

    }
}
