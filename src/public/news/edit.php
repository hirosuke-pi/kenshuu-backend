<?php

require_once '../../functions/autoload/views.php';
ViewComponent::importPage('news')->view(['mode' => MODE_EDIT]);
