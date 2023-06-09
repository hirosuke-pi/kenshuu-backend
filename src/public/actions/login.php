<?php

require_once '../../functions/autoload/actions.php';

PDOFactory::getNewPDOInstance();
$action = new ActionPage();

$action->post(
    function(array $params): ActionResponse {
        $responseData = ['email' => $params['email']];

        try {
            if ($params['email'] === '' || $params['password'] === '') {
                throw new Exception('メールアドレスとパスワードは必須です。');
            }
    
            $user = UsersRepo::getUserByEmail($params['email']);
            if (is_null($user)) {
                throw new Exception('ユーザーが見つかりません。');
            }
            if (!password_verify($params['password'], $user->password)) {
                throw new Exception('パスワードが間違っています。');
            }

            UserAuth::login($user->id);
            return new ActionResponse('/', 'success', 'こんにちは、'. $user->username .'さん！');
        }
        catch (Exception $error) {
            return new ActionResponse('/login.php', 'error', $error->getMessage(), $responseData);
        }
    },
    CSRF_LOGIN,
    ['email' => 'string', 'password' => 'string']
);

$action->dispatch();
