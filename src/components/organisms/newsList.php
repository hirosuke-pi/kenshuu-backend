<?php

$c = new Component($_PROPS, function() {
    $db = connectPostgreSQL();

    $postsDao = new PostsDAO($db);
    $posts = $postsDao->getPosts();

    return [
        'posts' => $posts,
    ];
});

?>

<div>
    <ul>
        <?php foreach ($c->raw_values['posts'] as $post) { ?>
            <!-- <?=var_log($post) ?> -->
            <li>
                <h3>
                    <a href="/news/<?= $post['id'] ?>">
                        <?=$post['title'] ?>
                    </a>
                </h3>
                <p><?=$post['body'] ?></p>
                <p><?=$post['createdAt'] ?></p>
                <hr/>
            </li>
        <?php } ?>
    </ul>
</div>
