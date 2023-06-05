<?php

require_once __DIR__ .'/../molecules/breadcrumb.php';
require_once __DIR__ .'/../molecules/newsEdit.php';
require_once __DIR__ .'/../molecules/newsActions.php';
require_once __DIR__ .'/../molecules/newsView.php';

class NewsDetail {
    public static function render(PostsDTO $post, string $mode): void {
        $editorMode = in_array($mode, [MODE_EDIT, MODE_NEW]);

        $breadcrumbProps = [
            ['name' => 'ニュース - '. $post->title, 'link' => $_SERVER['REQUEST_URI']]
        ];
        ?>
            <div class="w-full lg:w-3/6 ">
                <div class="m-3 p-2 rounded-lg">
                    <?=Breadcrumb::render($breadcrumbProps)?>
                </div>
                <?php if ($editorMode): ?>
                    <?=NewsEdit::render($post->id, $post->title, $post->body) ?>
                <?php else: ?>
                    <?=NewsActions::render($post->id) ?>
                    <?=NewsView::render($post) ?>
                <?php endif; ?>
            </div>       
        <?php
    }
}
