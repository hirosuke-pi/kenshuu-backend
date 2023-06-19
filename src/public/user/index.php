<?php

require_once '../../functions/autoload/views.php';
require_once '../../components/pages/user.php';

User::render();

PageController::unsetRedirectData();
