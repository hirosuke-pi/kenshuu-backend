<?php

class PostsRepo {
    /**
     * ユーザーIDを元に投稿数を取得
     *
     * @param string $userId ユーザーID
     * @param ?PDO $pdo PDOインスタンス
     * @return integer 投稿数
     */
    public static function getPostsCountByUserId(string $userId, PDO $pdo = null): int {
        if (is_null($pdo)) $pdo = PDOFactory::getPDOInstance();
        $postsDao = new PostsDAO($pdo);
        return $postsDao->getPostsCountByUserId($userId);
    }

    /**
     * ユーザーIDを元に投稿を取得
     *
     * @param string $userId ユーザーID
     * @param ?PDO $pdo PDOインスタンス
     * @return array 投稿リスト
     */
    public static function getPostsByUserId(string $userId, PDO $pdo = null): array {
        if (is_null($pdo)) $pdo = PDOFactory::getPDOInstance();
        $postsDao = new PostsDAO($pdo);
        return $postsDao->getPostsByUserId($userId);
    }

    /**
     * 投稿IDを元に投稿情報を取得
     *
     * @param string $postId 投稿ID
     * @param ?PDO $pdo PDOインスタンス
     * @return ?PostsDTO 投稿情報
     */
    public static function getPostById(string $postId, PDO $pdo = null): ?PostsDTO {
        if (is_null($pdo)) $pdo = PDOFactory::getPDOInstance();
        $postsDao = new PostsDAO($pdo);
        return $postsDao->getPostById($postId);
    }

    /**
     * 投稿IDを元に投稿リストを取得
     *
     * @param ?PDO $pdo PDOインスタンス
     * @return array 投稿リスト
     */
    public static function getPosts(PDO $pdo = null): array {
        if (is_null($pdo)) $pdo = PDOFactory::getPDOInstance();
        $postsDao = new PostsDAO($pdo);
        return $postsDao->getPosts();
    }

    /**
     * 投稿を作成
     *
     * @param string $userId ユーザーID
     * @param string $title タイトル
     * @param string $body 本文
     * @param ?PDO $pdo PDOインスタンス
     * @return string 投稿ID
     */
    public static function createPost(string $userId, string $title, string $body, PDO $pdo = null): string {
        if (is_null($pdo)) $db = PDOFactory::getPDOInstance();
        $postsDao = new PostsDAO($db);
        return $postsDao->createPost($userId, $title, $body);
    }
}
