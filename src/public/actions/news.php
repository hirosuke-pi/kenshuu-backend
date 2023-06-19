<?php

require_once '../../functions/autoload/actions.php';

/**
 * 投稿したユーザーかどうか認証
 * 
 * @param string $postId 投稿ID
 */
function authUserPost(string $postId): void {
    // ユーザー認証
    $userId = UserAuth::getLoginUserIdWithException();

    $db = PDOFactory::getPDOInstance();
    $postsDao = new PostsDAO($db);

    // ユーザー投稿チェック
    $post = $postsDao->getPostById($postId);
    if($userId !== $post->userId) {
        throw new Exception('投稿ユーザーと一致しません。');
    }
}

$action = new ActionPage();
$action->post(
    function(array $params): ActionResponse {
        try {
            if ($params['title'] === '' || $params['body'] === '') {
                throw new Exception('タイトルと本文は必須です。');
            }

            // ユーザーID取得
            $userId = UserAuth::getLoginUserIdWithException();

            // 一時的にユーザーを固定
            $userDto = UsersRepo::getUserById($userId);

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
        }
        catch (Exception $error) {
            return new ActionResponse('/news/post.php', 'error', $error->getMessage());
        }
    },
    CSRF_NEWS_CREATE,
    ['title' => 'string', 'body' => 'string']
);

$action->put(
    function(array $params): ActionResponse {
        try {
            if ($params['title'] === '' || $params['body'] === '') {
                throw new Exception('タイトルと本文は必須です。');
            }

            // 投稿ユーザーチェック
            authUserPost($params['id']);

            $db = PDOFactory::getPDOInstance();
            $postsDao = new PostsDAO($db);

            // ニュース追加
            $postsDao->putPostById($params['id'], $params['title'], $params['body']);

            return new ActionResponse('/news/index.php?id='. $params['id'], 'success', 'ニュースを編集しました。');
        }
        catch (Exception $error) {
            return new ActionResponse('/news/edit.php?id='. $params['id'], 'error', $error->getMessage());
        }
    },
    CSRF_NEWS_EDIT,
    ['title' => 'string', 'body' => 'string', 'id' => 'string']
);

$action->delete(
    function(array $params): ActionResponse {
        try {
            if ($params['id'] === '') {
                throw new Exception('ニュースが指定されていません。');
            }

            // 投稿ユーザーチェック
            authUserPost($params['id']);

            $db = PDOFactory::getPDOInstance();
            $postsDao = new PostsDAO($db);
            $postsDao->deletePostById($params['id']);

            return new ActionResponse('/', 'success', 'ニュースを削除しました。 ID: '. $params['id']);
        }
        catch (Exception $error) {
            return new ActionResponse('/', 'error', $error->getMessage());
        }
    },
    CSRF_NEWS_DELETE,
    ['id' => 'string']
);

$action->dispatch();
