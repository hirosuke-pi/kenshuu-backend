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
     * @param string $mode 表示モードか、編集モードか (固定値: MODE_VIEW, MODE_EDIT, MODE_CREATE)
     * @return void
     */
    public static function render(UsersDTO $user, ?PostsDTO $post, string $mode): void {
        $editorMode = in_array($mode, [MODE_EDIT, MODE_CREATE], true);

        $breadcrumbProps = [];
        if ($mode === MODE_EDIT) {
            $breadcrumbProps = [
                ['name' => 'ニュース - '. $post->title, 'link' => 'index.php?id='. $post->id],
                ['name' => 'ページを編集', 'link' => $_SERVER['REQUEST_URI']],
            ];
        }
        elseif ($mode === MODE_CREATE) {
            $breadcrumbProps = [
                ['name' => 'ユーザー - @'. $user->username, 'link' => '/user/index.php?id='. $user->id],
                ['name' => 'ニュースを作成', 'link' => $_SERVER['REQUEST_URI']],
            ];
        }
        elseif ($mode === MODE_VIEW) {
            $breadcrumbProps = [
                ['name' => 'ニュース - '. $post->title, 'link' => $_SERVER['REQUEST_URI']]
            ];
        }

        ?>
            <div class="w-full lg:w-3/6 ">
                <div class="m-3 p-2">
                    <?php Breadcrumb::render($breadcrumbProps)?>
                </div>
                <div class="m-3">
                    <?php AlertSession::render() ?>
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
