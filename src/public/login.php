<?php

require_once '../functions/autoload/views.php';
require_once '../components/pages/login.php';

Login::render();

PageController::unsetRedirectData();
