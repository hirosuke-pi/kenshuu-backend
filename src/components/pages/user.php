<?php

PageController::sessionStart();

[$head, $header, $footer, $end] = 
    ViewComponent::importTemplates(['head', 'header', 'footer', 'end']);
[$userDetail, $userPosts] = 
    ViewComponent::importOrganisms(['userDetail', 'userPosts']);

$user = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props): void {
        $db = FlashNewsDB::getPdo();

        // ユーザーデータ取得
        $usersDao = new UsersDAO($db);
        $user = $usersDao->getUserById($_GET['id']);

        if (!isset($user)) {
            PageController::redirect('/error.php', ['message' => 'ユーザーが見つかりませんでした。']);
        }

        // 投稿データ取得
        $postsDao = new PostsDAO($db);
        $postsCount = $postsDao->getPostsCountByUserId($_GET['id']);

        // バリュー追加
        $values->headProps = ['title' => 'Flash News - @'. $user->username];
        $values->userDetailProps = [
            'id' => $user->id,
            'postsCount' => $postsCount,
            'name' => $user->username,
        ];
        $values->userPostsProps = [
            'username' => $user->username
        ];
    }
);

?>

<?=$head->view($user->values->headProps)?>
    <body>
        <?=$header->view()?>
        <section class="flex justify-center flex-wrap-reverse items-end">
            <?=$userPosts->view($user->rawValues->userPostsProps)?>
            <?=$userDetail->view($user->rawValues->userDetailProps)?>
        </section>
        <?=$footer->view()?>
    </body>
<?=$end->view()?>
