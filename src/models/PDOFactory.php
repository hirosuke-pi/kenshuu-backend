<?php

class PDOFactory {
    const DB_NAME = 'kenshuu_backend';
    const DB_USER = 'postgres';
    const DB_PASSWORD = 'secret';
    const DB_HOST = 'database';

    private static $pdo;

    public static function getPDOInstance(bool $forceNew = false): PDO
    {
        if ($forceNew) {
            static::$pdo = static::getNewPDOInstance();
        }
        return static::$pdo;
    }

    public static function getNewPDOInstance(): PDO
    {
        static::$pdo = new PDO('pgsql:host='. self::DB_HOST .';dbname='. self::DB_NAME .'', self::DB_USER, self::DB_PASSWORD);
        static::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return static::$pdo;
    }
}
