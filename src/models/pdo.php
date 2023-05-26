<?php

class FlashNewsDB {
    const DB_NAME = 'kenshuu_backend';
    const DB_USER = 'postgres';
    const DB_PASSWORD = 'secret';
    const DB_HOST = 'database';

    public static function getPdo(): PDO {
        $db = new PDO('pgsql:host='. self::DB_HOST .';dbname='. self::DB_NAME .'', self::DB_USER, self::DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }
}
