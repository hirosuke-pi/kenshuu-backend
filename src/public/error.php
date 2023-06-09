<?php

require_once '../functions/autoload/views.php';
require_once '../components/pages/errorPage.php';

PDOFactory::getNewPDOInstance();

ErrorPage::render();
