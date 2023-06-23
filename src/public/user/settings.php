<?php

require_once '../../functions/autoload/views.php';
require_once '../../components/pages/userSettings.php';

PDOFactory::getNewPDOInstance();

UserSettings::render();
