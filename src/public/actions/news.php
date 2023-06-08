<?php

require_once '../../functions/autoload/actions.php';

PDOFactory::getNewPDOInstance();
$action = new ActionPage();

$action->post(
    function(array $params): ActionResponse {
        if ($params['title'] === '' || $params['body'] === '') {
            return new ActionResponse('/news/post.php', 'error', 'タイトルと本文は必須です。');
        }

        // 一時的にユーザーを固定
        $userDto = UsersRepo::getUserByEmail('test@test.com');

        // ニュース投稿データをDBに追加
        $postId = PostsRepo::createPost($userDto->id, $params['title'], $params['body']);

        // タグをDBに追加
        if (isset($params['tags'])) {
            TagsRepo::addTagsByPostId($params['tags'], $postId);
        }

        // 画像フォルダ作成
        $imageDir = __DIR__ .'/../img/news/'. $postId;
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

            $filename = ImagesRepo::createImageFile($postId, $key === 'thumbnail', $ext);
            move_uploaded_file($value['tmp_name'], $imageDir .'/'. $filename);
        }

        return new ActionResponse('/', 'success', 'ニュースを投稿しました。ID: '. $postId);
    },
    ['title' => 'string', 'body' => 'string']
);

$action->put(
    function(array $params): ActionResponse {
        if ($params['title'] === '' || $params['body'] === '') {
            return new ActionResponse('/news/edit.php?id='. $params['id'], 'error', 'タイトルと本文は必須です。');
        }

        $db = PDOFactory::getPDOInstance();
        $postsDao = new PostsDAO($db);
        $postsDao->putPostById($params['id'], $params['title'], $params['body']);

        return new ActionResponse('/news/index.php?id='. $params['id'], 'success', 'ニュースを編集しました。');
    },
    ['title' => 'string', 'body' => 'string', 'id' => 'string']
);

$action->delete(
    function(array $params): ActionResponse {
        $postId = $params['id'];
        $db = PDOFactory::getPDOInstance();
        $postsDao = new PostsDAO($db);
        $postsDao->deletePostById($postId);

        return new ActionResponse('/', 'success', 'ニュースを削除しました。 ID: '. $postId);
    },
    ['id' => 'string']
);

$action->dispatch();
