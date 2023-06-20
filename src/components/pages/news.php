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
     * クエリからニュースIDを取得し、ニュースを取得する
     * 存在しない場合はExceptionをスローする
     *
     * @return PostsDTO ニュースDTO
     */
    private static function getPostByPostIdQuery(): PostsDTO {
        if (!isset($_GET['id'])) {
            throw new Exception('不正なアクセスです。ニュースIDが指定されていません。');
        }
        $post = PostsRepo::getPostById($_GET['id']);
        if (is_null($post)) {
            throw new Exception('投稿が見つかりませんでした。');
        }

        return $post;
    }

    /**
     * ニュース詳細ページをレンダリング
     * 
     * @param NewsMode $mode ニュースの表示モード
     * @return void 
     */
    public static function render(NewsMode $mode): void {
        $title = '新規作成';
        $post = null;
        $user = null;

        try {
            switch($mode) {
                case NewsMode::CREATE:
                    $user = UsersRepo::getUserById(UserAuth::getLoginUserIdWithException());
                    break;
                case NewsMode::EDIT:
                    $post = self::getPostByPostIdQuery();
                    $user = UsersRepo::getUserById(UserAuth::getLoginUserIdWithException());
                    break;
                case NewsMode::VIEW:
                    $post = self::getPostByPostIdQuery();
                    $user = UsersRepo::getUserById($post->userId);
                    break;
            }
        }
        catch (Exception $error) {
            PageController::redirectWithStatus('/error.php', 'error', $error->getMessage());
            return;
        }

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
