<?php

require_once '../../functions/autoload/views.php';
require_once '../../components/pages/user.php';

PDOFactory::getNewPDOInstance();

User::render();
