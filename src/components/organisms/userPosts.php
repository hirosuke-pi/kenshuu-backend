<?php

[$newsCard, $breadcrumb] = ViewComponent::importMolecules(['newsCard', 'breadcrumb']);

$userPosts = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props) {
        $db = PDOFactory::getNewPDOInstance();

        $postsDao = new PostsDAO($db);
        $posts = $postsDao->getPostsByUserId($_GET['id']);

        $values->posts = $posts;
        $values->breadcrumbProps = [
            'paths' => [
                ['name' => 'ユーザー - @'. $props['username'], 'link' => $_SERVER['REQUEST_URI']]
            ]
        ];
    },
    propTypes: ['username' => 'string']
);

?>

<div class="w-full lg:w-3/6 ">
    <div class="mt-3 mx-3 p-2">
        <?=$breadcrumb->view($userPosts->values->breadcrumbProps)?>
    </div>
    <ul class="flex justify-center flex-wrap">
        <?php foreach ($userPosts->rawValues->posts as $post): ?>
            <?=$newsCard->view(['post' => $post, 'mode' => 'full'])?>
        <?php endforeach; ?>
    </ul>
</div>
