<?php

require_once '../../functions/autoload/actions.php';

PDOFactory::getNewPDOInstance();
$action = new ActionPage();

$action->post(
    function(array $params): ActionResponse {
        UserAuth::logout();
        return new ActionResponse('/', 'success', 'ログアウトしました。');
    },
    CSRF_LOGOUT
);

$action->dispatch();
