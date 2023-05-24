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

?>

<div>
    <ul class="flex justify-center flex-wrap">
        <?php foreach ($component->rawValues['posts'] as $post) { ?>
            <?=$newsCard->view(['post' => $post])?>
        <?php } ?>
    </ul>
</div>
