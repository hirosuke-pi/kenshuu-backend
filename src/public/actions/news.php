<?php

require_once '../../functions/autoload/actions.php';

$action = new ActionPage();

$action->get(function() {
    var_log('GET');
    var_log($_REQUEST);
    return new ActionResponse('/', []);
});

$action->post(function() {
    var_log('POST');
    var_log($_REQUEST);
    return new ActionResponse('/', []);
});

$action->delete(function() {
    var_log('DELETE');
    var_log($_REQUEST);
    return new ActionResponse('/', []);
});

$action->put(function() {
    var_log('PUT');
    var_log($_REQUEST);
    return new ActionResponse('/', []);
});

$action->dispatch();
