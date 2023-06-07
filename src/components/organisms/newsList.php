<?php

require_once __DIR__ .'/../molecules/newsCard.php';

class NewsList {
    /**
     * ニュースリストをカードでレンダリング
     *
     * @return void
     */
    public static function render(): void {
        $db = PDOFactory::getNewPDOInstance();
        $postsDao = new PostsDAO($db);

        $posts = $postsDao->getPosts();

        ?>
            <div>
                <ul class="flex justify-center flex-wrap">
                    <?php foreach ($posts as $post): ?>
                        <?php NewsCard::render($post) ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php
    }
}
