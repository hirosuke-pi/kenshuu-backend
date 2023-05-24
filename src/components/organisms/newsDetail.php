<?php



$component = new Component(
    $_PROPS,
    function() {
        $db = connectPostgreSQL();
        $postsDao = new PostsDAO($db);

        return [
            'post' => $postsDao->getPostById($_GET['id'])
        ];
    }
);

?>

<main>
    <div>
        
    </div>
</main>
