<?php

require_once __DIR__ .'/../molecules/newsCard.php';
require_once __DIR__ .'/../molecules/breadcrumb.php';

class UserPosts {
    /**
     * ユーザーのニュース投稿一覧をレンダリング
     *
     * @param string $username ユーザー名
     * @return void
     */
    public static function render(string $username): void {
        $db = PDOFactory::getNewPDOInstance();

        $postsDao = new PostsDAO($db);
        $posts = $postsDao->getPostsByUserId($_GET['id']);

        $breadcrumbProps = [
            ['name' => 'ユーザー - @'. $username, 'link' => $_SERVER['REQUEST_URI']]
        ];

        ?>
            <div class="w-full lg:w-3/6 ">
                <div class="mt-3 mx-3 p-2">
                    <?php Breadcrumb::render($breadcrumbProps) ?>
                </div>
                <ul class="flex justify-center flex-wrap">
                    <?php foreach ($posts as $post): ?>
                        <?php NewsCard::render($post, 'full') ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php
    }
}

?>
