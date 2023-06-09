<?php

class PostsRepo {
    /**
     * ユーザーIDを元に投稿数を取得
     *
     * @param string $userId ユーザーID
     * @return integer 投稿数
     */
    public static function getPostsCountByUserId(string $userId): int {
        $db = PDOFactory::getPDOInstance();
        $postsDao = new PostsDAO($db);
        return $postsDao->getPostsCountByUserId($userId);
    }

    /**
     * ユーザーIDを元に投稿を取得
     *
     * @param string $userId ユーザーID
     * @return array 投稿リスト
     */
    public static function getPostsByUserId(string $userId): array {
        $db = PDOFactory::getPDOInstance();
        $postsDao = new PostsDAO($db);
        return $postsDao->getPostsByUserId($userId);
    }

    /**
     * 投稿IDを元に投稿情報を取得
     *
     * @param string $postId 投稿ID
     * @return ?PostsDTO 投稿情報
     */
    public static function getPostById(string $postId): ?PostsDTO {
        $db = PDOFactory::getPDOInstance();
        $postsDao = new PostsDAO($db);
        return $postsDao->getPostById($postId);
    }

    /**
     * 投稿IDを元に投稿リストを取得
     *
     * @return array 投稿リスト
     */
    public static function getPosts(): array {
        $db = PDOFactory::getPDOInstance();
        $postsDao = new PostsDAO($db);
        return $postsDao->getPosts();
    }

    /**
     * 投稿を作成
     *
     * @param string $userId ユーザーID
     * @param string $title タイトル
     * @param string $body 本文
     * @return string 投稿ID
     */
    public static function createPost(string $userId, string $title, string $body): string {
        $db = PDOFactory::getPDOInstance();
        $postsDao = new PostsDAO($db);
        return $postsDao->createPost($userId, $title, $body);
    }
}
