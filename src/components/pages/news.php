<?php

session_start();
$head = Component::viewTemplate('head');
$header = Component::viewTemplate('header');
$footer = Component::viewTemplate('footer');
$end = Component::viewTemplate('end');

$newsDetail = Component::viewOrganism('newsDetail');
$userInfo = Component::viewOrganism('userInfo');

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
            <?=$newsDetail->view(['post' => $component->values['post']])?>
            <?=$userInfo->view(['user' => $component->values['user']])?>
        </section>
        <?=$footer->view()?>
    </body>
<?=$end->view()?>
