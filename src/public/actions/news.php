<?php

require_once '../../functions/autoload/actions.php';


$action = new ActionPage();

$action->post(function($params) {
    $db = connectPostgreSQL();
    $postsDao = new PostsDAO($db);

    // 一時的にユーザーを固定
    $usersDao = new UsersDAO($db);
    $userDto = $usersDao->getUserByEmail('test@test.com');

    $postsDao->createPost($userDto->id, $params['title'], $params['body']);

    return new ActionResponse('/');
}, ['title' => 'string', 'body' => 'string']);


$action->dispatch();
