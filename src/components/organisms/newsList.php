<?php

$newsCard = Component::viewMolecule('newsCard');

$c = new Component($_PROPS, function() {
    $db = connectPostgreSQL();
    $postsDao = new PostsDAO($db);

    return [
        'posts' => $postsDao->getPosts()
    ];
});

?>

<div>
    <ul class="flex justify-center flex-wrap">
        <?php foreach ($c->rawValues['posts'] as $post) { ?>
            <?=$newsCard->view(['post' => $post])?>
        <?php } ?>
    </ul>
</div>
