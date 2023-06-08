<?php

require_once __DIR__ .'/../atoms/alert.php';

require_once __DIR__ .'/../molecules/breadcrumb.php';
require_once __DIR__ .'/../molecules/newsEdit.php';
require_once __DIR__ .'/../molecules/newsActions.php';
require_once __DIR__ .'/../molecules/newsView.php';
require_once __DIR__ .'/../molecules/alertSession.php';

class NewsDetail {
    /**
     * ニュース詳細コンポーネントをレンダリング
     *
     * @param UsersDTO $user ユーザーDTO
     * @param ?PostsDTO $post 投稿DTO
     * @param NewsMode $mode ニュース表示モード
     * @return void
     */
    public static function render(UsersDTO $user, ?PostsDTO $post, NewsMode $mode): void {
        $editorMode = $mode === NewsMode::EDIT || $mode === NewsMode::CREATE;

        $breadcrumbProps = match($mode) {
            NewsMode::EDIT => [
                ['name' => 'ニュース - '. $post->title, 'link' => '/news/index.php?id='. $post->id],
                ['name' => 'ページを編集', 'link' => $_SERVER['REQUEST_URI']],
            ],
            NewsMode::CREATE => [
                ['name' => 'ユーザー - @'. $user->username, 'link' => '/user/index.php?id='. $user->id],
                ['name' => 'ニュースを作成', 'link' => $_SERVER['REQUEST_URI']],
            ],
            default => [
                ['name' => 'ニュース - '. $post->title, 'link' => $_SERVER['REQUEST_URI']]
            ]
        };

        ?>
            <div class="w-full lg:w-3/6 ">
                <div class="m-3 p-2">
                    <?php Breadcrumb::render($breadcrumbProps)?>
                </div>
                <div class="m-3">
                    <?=AlertSession::render() ?>
                </div>
                <?php if ($editorMode): ?>
                    <?php NewsEdit::render($post, $mode) ?>
                <?php else: ?>
                    <?php NewsActions::render($post->id) ?>
                    <?php NewsView::render($post) ?>
                <?php endif; ?>
            </div>       
        <?php
    }
}
