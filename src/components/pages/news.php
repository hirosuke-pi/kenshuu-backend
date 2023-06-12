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
     * @param string $mode 表示モードか、編集モードか (固定値: MODE_VIEW, MODE_EDIT, MODE_CREATE)
     * @return void 
     */
    public static function render(string $mode): void {
        $db = PDOFactory::getNewPDOInstance();

        $usersDao = new UsersDAO($db);
        $user = $usersDao->getUserByEmail('test@test.com');

        $postsDao = new PostsDAO($db);
        $postsCount = $postsDao->getPostsCountByUserId($user->id);

        $title = '新規作成';
        $post = null;
        if (in_array($mode, [MODE_VIEW, MODE_EDIT])) {
            // 編集・閲覧モード
            // 投稿データ取得
            $post = $postsDao->getPostById($_GET['id']);
            if (is_null($post)) {
                PageController::redirect('/error.php', ['message' => '投稿が見つかりませんでした。']);
            }
            $title = $post->title;
        }
    
        ?>
            <?php Head::render('Flash News - '. $title) ?>
                <body>
                    <?php Header::render() ?>
                    <section class="flex justify-center flex-wrap items-start">
                        <?php NewsDetail::render($user, $post, $mode) ?>
                        <?php NewsInfo::render($user, $postsCount) ?>
                    </section>
                    <?php Footer::render() ?>
                </body>
            <?php End::render() ?>
        <?php

    }
}
