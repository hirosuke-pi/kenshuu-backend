<?php

require_once '../../functions/autoload/views.php';
require_once '../../components/pages/news.php';

News::render(NewsMode::EDIT);

PageController::unsetRedirectData();
