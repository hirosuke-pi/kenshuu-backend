<?php

class PDOFactory {
    const DB_NAME = 'kenshuu_backend';
    const DB_USER = 'postgres';
    const DB_PASSWORD = 'secret';
    const DB_HOST = 'database';

    private static PDO $pdo;

    /**
     * PDOインスタンスを取得
     *
     * @param boolean $forceNew 強制的にPDOを再生成するかどうか
     * @return PDO PDOインスタンス
     */
    public static function getPDOInstance(bool $forceNew = false): PDO
    {
        if ($forceNew) {
            static::$pdo = static::getNewPDOInstance();
        }
        return static::$pdo;
    }

    /**
     * 新しいPDOインスタンスを生成
     *
     * @return PDO PDOインスタンス
     */
    public static function getNewPDOInstance(): PDO
    {
        static::$pdo = new PDO('pgsql:host='. self::DB_HOST .';dbname='. self::DB_NAME .'', self::DB_USER, self::DB_PASSWORD);
        static::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return static::$pdo;
    }
}
