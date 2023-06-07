<?php

require_once '../../functions/autoload/actions.php';


$action = new ActionPage();

$action->post(
    function(array $params): ActionResponse {
        $db = PDOFactory::getNewPDOInstance();
        $imagesDao = new ImagesDAO($db);

        if ($params['title'] === '' || $params['body'] === '') {
            return new ActionResponse('/news/post.php', 'error', 'タイトルと本文は必須です。');
        }

        // 一時的にユーザーを固定
        $usersDao = new UsersDAO($db);
        $userDto = $usersDao->getUserByEmail('test@test.com');

        // ニュース投稿データをDBに追加
        $postsDao = new PostsDAO($db);
        $newsId = $postsDao->createPost($userDto->id, $params['title'], $params['body']);

        // タグをDBに追加
        if (isset($params['tags'])) {
            $tagsDao = new TagsDAO($db);
            foreach($params['tags'] as $tag) {
                $tagsDao->addTagByPostId($tag, $newsId);
            }
        }

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
            $filename = $imageId .'.'. h($ext);

            // 画像をDBに登録
            $imagesDao->createImage($imageId, $newsId, $key === 'thumbnail', $filename);

            move_uploaded_file($value['tmp_name'], $imageDir .'/'. $filename);
        }

        return new ActionResponse('/', 'success', 'ニュースを投稿しました。ID: '. $newsId);
    },
    ['title' => 'string', 'body' => 'string']
);

$action->put(
    function(array $params): ActionResponse {
        $db = PDOFactory::getNewPDOInstance();
        $postsDao = new PostsDAO($db);
        $postsDao->putPostById($_GET['id'], $params['title'], $params['body']);

        return new ActionResponse('/news/index.php?id='. $_GET['id'], 'success', 'ニュースを編集しました。');
    },
    ['title' => 'string', 'body' => 'string', 'id' => 'string']
);

$action->delete(
    function(array $params): ActionResponse {
        $newsId = $_GET['id'];
        $db = PDOFactory::getNewPDOInstance();
        $postsDao = new PostsDAO($db);
        $postsDao->deletePostById($newsId);

        return new ActionResponse('/', 'success', 'ニュースを削除しました。 ID: '. $newsId);
    },
    ['id' => 'string']
);

$action->dispatch();
