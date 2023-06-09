<?php

require_once '../functions/autoload/views.php';
require_once '../components/pages/home.php';

PDOFactory::getNewPDOInstance();

Home::render();
