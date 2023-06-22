<?php

require_once '../../functions/autoload/actions.php';

PDOFactory::getNewPDOInstance();
$action = new ActionPage();

$action->post(
    function(array $params): ActionResponse {
        $responseData = ['email' => $params['email'], 'username' => $params['username']];
        try {
            $profileImageExt = null;
            if (in_array('', [$params['email'], $params['password1'], $params['username']])) {
                throw new Exception('ユーザー名とメールアドレス、パスワードは必須です。');
            }
            elseif ($params['password1'] !== $params['password2']) {
                throw new Exception('確認用パスワードと一致しません。');
            }
            elseif (isset($_FILES['profile-image'])) {
                $profileImageExt = strtolower(pathinfo($_FILES['profile-image']['name'], PATHINFO_EXTENSION));
                if (!in_array($profileImageExt, ['jpg', 'jpeg', 'png', 'gif'])) {
                    throw new Exception('プロフィール画像はjpg, jpeg, png, gifのいずれかの形式でアップロードしてください。');
                }
            }

            // ユーザー登録
            $userId = UsersRepo::createUser($params['username'], $params['email'], $params['password1'], $profileImageExt);

            // プロフィール画像
            if (!is_null($profileImageExt)) {
                $profileImgDir = __DIR__ .'/../img/users';
                if (!file_exists($profileImgDir)) {
                    mkdir($profileImgDir, 0777, true);
                }

                move_uploaded_file($_FILES['profile-image']['tmp_name'], $profileImgDir .'/'. $userId .'.'. $profileImageExt);
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

$action->dispatch();
