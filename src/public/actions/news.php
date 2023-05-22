<?php

require_once '../../functions/autoload/actions.php';

$action = new Action();

$action->get('/', function($request) {
    
    return new ActionResponse(ActionResponseStatus::Success, []);
});

$action->dispatch();
