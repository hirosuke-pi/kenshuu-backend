<?php

require_once __DIR__ .'/../molecules/newsCard.php';

class NewsList {
    /**
     * ニュースリストをカードでレンダリング
     *
     * @return void
     */
    public static function render(): void {
        $db = PDOFactory::getPDOInstance();
        $postsDao = new PostsDAO($db);

        $posts = $postsDao->getPosts();

        ?>
            <div>
                <ul class="flex justify-center flex-wrap">
                    <?php foreach ($posts as $post): ?>
                        <?php NewsCard::render($post, 'card') ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php
    }
}
