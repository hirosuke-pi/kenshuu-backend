<?php

require_once __DIR__ .'/../molecules/breadcrumb.php';
require_once __DIR__ .'/../molecules/newsEdit.php';
require_once __DIR__ .'/../molecules/newsActions.php';
require_once __DIR__ .'/../molecules/newsView.php';

class NewsDetail {
    /**
     * ニュース詳細コンポーネントをレンダリング
     *
     * @param PostsDTO $post 投稿DTO
     * @param string $mode 表示モードか、編集モードか (固定値: MODE_VIEW, MODE_EDIT, MODE_NEW)
     * @return void
     */
    public static function render(PostsDTO $post, string $mode): void {
        $newsDetail = new NewsDetail(['post' => $post, 'mode' => $mode]);
        $editorMode = in_array($mode, [MODE_EDIT, MODE_NEW], true);

        $breadcrumbProps = [
            ['name' => 'ニュース - '. $post->title, 'link' => $_SERVER['REQUEST_URI']]
        ];
        ?>
            <div class="w-full lg:w-3/6 ">
                <div class="m-3 p-2 rounded-lg">
                    <?php Breadcrumb::render($breadcrumbProps) ?>
                </div>
                <?php if ($editorMode): ?>
                    <?php NewsEdit::render($post->id, $post->title, $post->body) ?>
                <?php else: ?>
                    <?php NewsActions::render($post->id) ?>
                    <?php NewsView::render($post->title, $post->body, $post->createdAt) ?>
                <?php endif; ?>
            </div>       
        <?php
    }
}
