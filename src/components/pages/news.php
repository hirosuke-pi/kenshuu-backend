<?php

session_start();
[$head, $header, $footer, $end] = ViewComponent::importTemplates(['head', 'header', 'footer', 'end']);
[$newsDetail, $userInfo] = ViewComponent::importOrganisms(['newsDetail', 'userInfo']);

$component = new Component(
    $_PROPS,
    function() {
        $db = connectPostgreSQL();

        // 投稿データ取得
        $postsDao = new PostsDAO($db);
        $post = $postsDao->getPostById($_GET['id']);
        if (!isset($post)) {
            // jumpLocation('/error.php', ['message' => '投稿が見つかりませんでした']);
        }

        // ユーザーデータ取得
        $usersDao = new UsersDAO($db);
        $user = $usersDao->getUserById($post->userId);

        return [
            'post' => $post,
            'user' => $user
        ];
    }
);

?>

<?=$head->view(['title' => 'Flash News - '])?>
    <body>
        <?=$header->view()?>
        <section class="flex justify-center flex-wrap">
            <?=$newsDetail->view(['post' => $component->rawValues['post']])?>
            <?=$userInfo->view(['user' => $component->rawValues['user']])?>
        </section>
        <?=$footer->view()?>
    </body>
<?=$end->view()?>
