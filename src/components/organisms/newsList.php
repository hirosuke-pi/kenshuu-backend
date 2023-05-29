<?php

[$newsCard] = ViewComponent::importMolecules(['newsCard']);

$newsList = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values) {
        $db = FlashNewsDB::getPdo();
        $postsDao = new PostsDAO($db);

        $values->posts = $postsDao->getPosts();
    }
);

$posts = $newsList->rawValues->posts;

?>

<div>
    <ul class="flex justify-center flex-wrap">
        <?php foreach ($posts as $post): ?>
            <?=$newsCard->view(['post' => $post, 'mode' => 'card'])?>
        <?php endforeach; ?>
    </ul>
</div>
