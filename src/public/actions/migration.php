<?php

require_once '../../functions/autoload/actions.php';

$db = connectPostgreSQL();

$usersDao = new UsersDAO($db);

$usersDto = $usersDao->createUser('test', 'test@test.com', 'test');
var_log($usersDto);

$user = $usersDao->getUserById('user_850744847646c77ade943a');
var_log($user);
