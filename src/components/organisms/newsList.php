<?php

require_once __DIR__ .'/../molecules/newsCard.php';
require_once __DIR__ .'/../molecules/alertSession.php';

class NewsList {
    /**
     * ニュースリストをカードでレンダリング
     *
     * @return void
     */
    public static function render(array $posts): void {
        ?>
            <div class="m-3">
                <?php AlertSession::render() ?>
            </div>
            <div>
                <ul class="flex justify-center flex-wrap">
                    <?php if (count($posts) > 0): ?>
                        <?php foreach ($posts as $post): ?>
                            <?php NewsCard::render($post, CardSize::SMALL) ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="flex justify-center items-center my-3">
                            <p class="text-gray-700 text-2xl">ニュースがありません！</p>
                        </div>
                    <?php endif; ?>
                </ul>
            </div>
        <?php
    }
}
