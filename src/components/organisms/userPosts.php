<?php

require_once __DIR__ .'/breadcrumb.php';
require_once __DIR__ .'/../molecules/newsCard.php';

class userPosts {
    public static function render(string $username): void {
        $db = PDOFactory::getNewPDOInstance();

        $postsDao = new PostsDAO($db);
        $posts = $postsDao->getPostsByUserId($_GET['id']);

        $props = [['name' => 'ユーザー - @'. $username, 'link' => $_SERVER['REQUEST_URI']]];

        ?>
            <div class="w-full lg:w-3/6 ">
                <div class="mt-3 mx-3 p-2">
                    <?=Breadcrumb::render($props) ?>
                </div>
                <ul class="flex justify-center flex-wrap">
                    <?php foreach ($posts as $post): ?>
                        <?=NewsCard::render($post) ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php
    }
}
