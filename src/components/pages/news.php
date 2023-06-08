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
     * @param NewsMode $mode ニュースの表示モード
     * @return void 
     */
    public static function render(NewsMode $mode): void {
        $title = '新規作成';
        $post = null;
        if (in_array($mode, [NewsMode::EDIT, NewsMode::VIEW], true)) {
            if (!isset($_GET['id'])) {
                PageController::redirectWithStatus('/error.php', 'error', 'ニュースIDは数値で指定してください。');
            }
            $post = PostsRepo::getPostById($_GET['id']);
            if (is_null($post)) {
                PageController::redirectWithStatus('/error.php', 'error', '投稿が見つかりませんでした。');
            }
            $title = $post->title;
        }
        $user = UsersRepo::getUserByEmail('test@test.com');

        ?>
            <?php Head::render('Flash News - '. $title) ?>
                <body>
                    <?php Header::render() ?>
                    <section class="flex justify-center flex-wrap items-start">
                        <?php NewsDetail::render($user, $post, $mode) ?>
                        <?php NewsInfo::render($user, $post, $mode) ?>
                    </section>
                    <?php Footer::render() ?>
                </body>
            <?php End::render() ?>
        <?php
    }
}
