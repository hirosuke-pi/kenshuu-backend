<?php

require_once '../../functions/autoload/actions.php';


$action = new ActionPage();

$action->post(
    function(array $params): ActionResponse {
        $db = PDOFactory::getNewPDOInstance();
        $postsDao = new PostsDAO($db);

        // 一時的にユーザーを固定
        $usersDao = new UsersDAO($db);
        $userDto = $usersDao->getUserByEmail('test@test.com');

        $postsDao->createPost($userDto->id, $params['title'], $params['body']);

        return new ActionResponse('/');
    },
    ['title' => 'string', 'body' => 'string']
);

$action->put(
    function(array $params): ActionResponse {
        $db = PDOFactory::getNewPDOInstance();
        $postsDao = new PostsDAO($db);
        $postsDao->putPostById($_GET['id'], $params['title'], $params['body']);

        return new ActionResponse('/news/index.php?id='. $_GET['id']);
    },
    ['title' => 'string', 'body' => 'string', 'id' => 'string']
);

$action->delete(
    function(array $params): ActionResponse {
        $db = PDOFactory::getNewPDOInstance();
        $postsDao = new PostsDAO($db);
        $postsDao->deletePostById($_GET['id']);

        return new ActionResponse('/');
    },
    ['id' => 'string']
);

$action->dispatch();
