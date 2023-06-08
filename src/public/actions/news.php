<?php

require_once '../../functions/autoload/actions.php';


$action = new ActionPage();

$action->post(
    function(array $params): ActionResponse {
        $db = PDOFactory::getNewPDOInstance();
        $imagesDao = new ImagesDAO($db);

        // 一時的にユーザーを固定
        $usersDao = new UsersDAO($db);
        $userDto = $usersDao->getUserByEmail('test@test.com');

        $postsDao = new PostsDAO($db);
        $newsId = $postsDao->createPost($userDto->id, $params['title'], $params['body']);

        // 画像フォルダ作成
        $imageDir = __DIR__ .'/../img/news/'. $newsId;
        mkdir($imageDir, 0777, true);

        // 画像ファイル移動
        foreach ($_FILES as $key => $value) {
            if ($value['error'] !== 0) {
                continue;
            }
            $ext = strtolower(pathinfo($value['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                continue;
            }

            $imageId = 'image_' . uniqid(mt_rand());
            $filename = $imageId .'.'. convertSpecialCharsToHtmlEntities($ext);
            $imagesDao->createImage($imageId, $newsId, $key === 'thumbnail', $filename);

            move_uploaded_file($value['tmp_name'], $imageDir .'/'. $filename);
        }

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
