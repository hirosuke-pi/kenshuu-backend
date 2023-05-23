<?php

require_once '../../functions/autoload/actions.php';


$action = new ActionPage();

$action->post(function($params) {
    return new ActionResponse('/', $params);
}, ['title' => 'string', 'body' => 'string']);


$action->dispatch();
