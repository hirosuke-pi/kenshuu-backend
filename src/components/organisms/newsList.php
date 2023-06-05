<?php

[$newsCard] = ViewComponent::importMolecules(['newsCard']);

$component = new Component(
    $_PROPS,
    function() {
        $db = connectPostgreSQL();
        $postsDao = new PostsDAO($db);

        return [
            'posts' => $postsDao->getPosts()
        ];
    }
);

$posts = $component->rawValues['posts'];

?>

<div>
    <ul class="flex justify-center flex-wrap">
        <?php foreach ($posts as $post): ?>
            <?=$newsCard->view(['post' => $post])?>
        <?php endforeach; ?>
    </ul>
</div>
