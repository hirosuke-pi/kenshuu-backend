<?php

PageController::sessionStart();

[$head, $header, $footer, $end] = 
    ViewComponent::importTemplates(['head', 'header', 'footer', 'end']);
[$newsDetail, $userInfo, $breadcrumb] = 
    ViewComponent::importOrganisms(['newsDetail', 'userInfo', 'breadcrumb']);

$news = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props): void {
        $db = PDOFactory::getNewPDOInstance();

        // 投稿データ取得
        $postsDao = new PostsDAO($db);
        $post = $postsDao->getPostById($_GET['id']);
        if (!isset($post)) {
            PageController::redirect('/error.php', ['message' => '投稿が見つかりませんでした']);
        }

        // ユーザーデータ取得
        $usersDao = new UsersDAO($db);
        $user = $usersDao->getUserById($post->userId);
        $postsCount = $postsDao->getPostsCountByUserId($post->userId);

        // バリュー追加
        $values->headProps = ['title' => 'Flash News - '. $post->title];
        $values->post = $post;
        $values->user = $user;
        $values->postsCount = $postsCount;

        $values->newsDetailProps = ['post' => $post];
        $values->userInfoProps = [
            'user' => $user,
            'postsCount' => $postsCount
        ];
    }
);

?>

<?=$head->view($news->values->headProps)?>
    <body>
        <?=$header->view()?>
        <section class="flex justify-center flex-wrap items-start">
            <?=$newsDetail->view($news->values->newsDetailProps)?>
            <?=$userInfo->view($news->values->userInfoProps)?>
        </section>
        <?=$footer->view()?>
    </body>
<?=$end->view()?>
