<?php

require_once '../../functions/autoload/views.php';
require_once '../../components/pages/news.php';

PDOFactory::getNewPDOInstance();

News::render(NewsMode::CREATE);
