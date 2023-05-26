<?php

function var_log($dump) {
    echo '<pre>';
    var_dump($dump);
    echo '</pre>';
}

function checkKeyTypes(array $params, array $requirePropKeys) {
    foreach ($requirePropKeys as $key => $type) {
        if (!array_key_exists($key, $params)) {
            // 必須パラメーターが存在しなかった場合はエラーをスロー
            throw new Exception('Required parameter key not found: ' . $key);
        }
        elseif (gettype($params[$key]) !== $type) {
            // 必須パラメーターが型が一致しなければエラーをスロー
            throw new Exception('Required parameter type not match: ' . $key);
        }
    }
}

function connectPostgreSQL(): PDO {
    $db = new PDO('pgsql:host='. DB_HOST .';dbname='. DB_NAME .'', DB_USER, DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}

function getDateTimeFormat(string $datetime): string {
    $now = new DateTime($datetime);
    return $now->format('Y/m/d H:i:s');
}

function jumpLocation(string $path, array $data = []) {
    $_SESSION[JUMP_PAGE_INDEX] = $data;
    header('location: ' . $path);
    exit;
}

function getRefarerData(): array {
    return isset($_SESSION[JUMP_PAGE_INDEX]) ? $_SESSION[JUMP_PAGE_INDEX] : [];
}

function h($value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
