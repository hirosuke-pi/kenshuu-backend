<?php

require_once '../../functions/autoload/actions.php';

/**
 * 入力値のチェック
 *
 * @param array $params パラメータ
 * @return ?string プロフィール画像の拡張子
 */
function checkInputType(array $params): ?string {
    $profileImageExt = null;
    if (in_array('', [$params['email'], $params['password1'], $params['username']])) {
        throw new Exception('ユーザー名とメールアドレス、パスワードは必須です。');
    }
    elseif ($params['password1'] !== $params['password2']) {
        throw new Exception('確認用パスワードと一致しません。');
    }
    elseif (isset($_FILES['profile-image']) && $_FILES['profile-image']['error'] === UPLOAD_ERR_OK) {
        $profileImageExt = strtolower(pathinfo($_FILES['profile-image']['name'], PATHINFO_EXTENSION));
        if (!in_array($profileImageExt, ['jpg', 'jpeg', 'png', 'gif'])) {
            throw new Exception('プロフィール画像はjpg, jpeg, png, gifのいずれかの形式でアップロードしてください。');
        }
    }
    elseif ($params['username'] < 5 || $params['username'] > 20) {
        throw new Exception('ユーザー名は5文字以上20文字以下で入力してください。');
    }
    elseif ($params['password1'] < 8) {
        throw new Exception('パスワードは8文字以上で入力してください。'. strlen($params['password1']));
    }
    elseif (!preg_match('/^[a-zA-Z0-9_+-]+(.[a-zA-Z0-9_+-]+)*@([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)+[a-zA-Z]{2,}$/', $params['email'])) {
        throw new Exception('不正なメールアドレス形式でです。');
    }

    return $profileImageExt;
}

/**
 * プロフィール画像をpublic/img/usersに移動
 *
 * @param string $userId ユーザーID
 * @param string $profileImageExt プロフィール画像の拡張子
 * @return boolean 移動に成功したかどうか
 */
function moveUserProfileImageToPublic(string $userId, string $profileImageExt): bool {
    $profileImgDir = __DIR__ .'/../img/users';
    if (!file_exists($profileImgDir)) {
        mkdir($profileImgDir, 0777, true);
    }

    return move_uploaded_file($_FILES['profile-image']['tmp_name'], $profileImgDir .'/'. $userId .'.'. $profileImageExt);
}


PDOFactory::getNewPDOInstance();
$action = new ActionPage();

$action->post(
    function(array $params): ActionResponse {
        $responseData = ['email' => $params['email'], 'username' => $params['username']];
        try {
            $profileImageExt = checkInputType($params);

            // ユーザー登録
            $userId = UsersRepo::createUser($params['username'], $params['email'], $params['password1'], $profileImageExt ?? '');

            // プロフィール画像
            if (!is_null($profileImageExt)) {
                moveUserProfileImageToPublic($userId, $profileImageExt);
            }

            // ユーザーログイン
            UserAuth::login($userId);
            return new ActionResponse('/', 'success', 'ユーザーを登録しました。ようこそ、'. $params['username'] .'さん！');
        }
        catch (Exception $error) {
            return new ActionResponse('/signup.php', 'error', $error->getMessage(), $responseData);
        }
    },
    CSRF_SIGNUP,
    ['email' => 'string', 'password1' => 'string', 'password2' => 'string', 'username' => 'string']
);

$action->put(
    function(array $params): ActionResponse {
        try {
            $userId = UserAuth::getLoginUserIdWithException();
            $profileImageExt = checkInputType($params);

            UsersRepo::updateUser($userId, $params['username'], $params['email'], $params['password1'], $profileImageExt);

            if (!is_null($profileImageExt)) {
                moveUserProfileImageToPublic($userId, $profileImageExt);
            }

            return new ActionResponse('/user/settings.php', 'success', 'ユーザーの設定を更新しました。');
        }
        catch (Exception $error) {
            return new ActionResponse('/user/settings.php', 'error', $error->getMessage());
        }
    },
    CSRF_SIGNUP,
    ['email' => 'string', 'password1' => 'string', 'password2' => 'string', 'username' => 'string']
);

$action->dispatch();
