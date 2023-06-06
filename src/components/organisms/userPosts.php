<?php

require_once __DIR__ .'/../molecules/newsCard.php';
require_once __DIR__ .'/../molecules/breadcrumb.php';

class UserPosts {
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
                    <?=Breadcrumb::render($breadcrumbProps)?>
                </div>
                <ul class="flex justify-center flex-wrap">
                    <?php foreach ($posts as $post): ?>
                        <?=NewsCard::render($post, 'full') ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php
    }
}

?>
