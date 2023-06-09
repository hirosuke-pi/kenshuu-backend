<?php

require_once '../../functions/autoload/actions.php';

PDOFactory::getNewPDOInstance();
$action = new ActionPage();

$action->post(
    function(array $params): ActionResponse {
        $responseData = ['email' => $params['email']];
        if ($params['email'] === '' || $params['password'] === '') {
            return new ActionResponse('/login.php', 'error', 'メールアドレスとパスワードは必須です。', $responseData);
        }

        $user = UsersRepo::getUserByEmail($params['email']);
        if (is_null($user)) {
            return new ActionResponse('/login.php', 'error', 'ユーザーが見つかりません。', $responseData);
        }
        if (!password_verify($params['password'], $user->password)) {
            return new ActionResponse('/login.php', 'error', 'パスワードが間違っています。', $responseData);
        }

        UserAuth::login($user->id);
        return new ActionResponse('/', 'success', 'こんにちは、'. $user->username .'さん！');
    },
    CSRF_LOGIN,
    ['email' => 'string', 'password' => 'string']
);

$action->dispatch();
