<?php

PageController::sessionStart();

[$head, $header, $footer, $end] = 
    ViewComponent::importTemplates(['head', 'header', 'footer', 'end']);
[$newsDetail, $newsInfo] = 
    ViewComponent::importOrganisms(['newsDetail', 'newsInfo']);

$news = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props): void {
        $db = FlashNewsDB::getPdo();

        if (in_array($props['mode'], [MODE_VIEW, MODE_EDIT])) {
            // 編集・閲覧モード
            // 投稿データ取得
            $postsDao = new PostsDAO($db);
            $post = $postsDao->getPostById($_GET['id']);
            if (!isset($post)) {
                PageController::redirect('/error.php', ['message' => '投稿が見つかりませんでした。']);
            }

            // ユーザーデータ取得
            $usersDao = new UsersDAO($db);
            $user = $usersDao->getUserById($post->userId);
            $postsCount = $postsDao->getPostsCountByUserId($post->userId);

            // バリュー追加
            $values->headProps = ['title' => 'Flash News - '. $post->title];

            $values->newsDetailProps = [
                'post' => $post,
                'mode' => $props['mode']
            ];
            $values->newsInfoProps = [
                'user' => $user,
                'postsCount' => $postsCount,
                'mode' => $props['mode']
            ];
        }
        elseif ($props['mode'] === MODE_CREATE) {
            // 新規作成モード
            // ユーザーデータ取得
            $usersDao = new UsersDAO($db);
            $user = $usersDao->getUserByEmail('test@test.com');
            $postsDao = new PostsDAO($db);
            $postsCount = $postsDao->getPostsCountByUserId($user->id);

            // バリュー追加
            $values->headProps = ['title' => 'Flash News - ニュースを作成'];

            $values->newsDetailProps = [
                'post' => (object)[],
                'mode' => $props['mode']
            ];
            $values->newsInfoProps = [
                'user' => $user,
                'postsCount' => $postsCount,
                'mode' => $props['mode']
            ];
        }
        else {
            PageController::redirect('/error.php', ['message' => '不正なアクセスです。']);
        }
    },
    propTypes: ['mode' => 'string']
);

?>

<?=$head->view($news->values->headProps)?>
    <body>
        <?=$header->view()?>
        <section class="flex justify-center flex-wrap items-start">
            <?=$newsDetail->view($news->rawValues->newsDetailProps)?>
            <?=$newsInfo->view($news->rawValues->newsInfoProps)?>
        </section>
        <?=$footer->view()?>
    </body>
<?=$end->view()?>
