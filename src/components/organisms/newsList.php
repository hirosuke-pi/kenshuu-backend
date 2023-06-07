<?php

require_once __DIR__ .'/../molecules/newsCard.php';
require_once __DIR__ .'/../molecules/alertSession.php';

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
            <div class="m-3">
                <?=AlertSession::render() ?>
            </div>
            <div>
                <ul class="flex justify-center flex-wrap">
                    <?php foreach ($posts as $post): ?>
                        <?=NewsCard::render($post, 'card') ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php
    }
}
