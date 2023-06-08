<?php

class PostsRepo {
    public static function getPostsCountByUserId(string $userId): int {
        $db = PDOFactory::getPDOInstance();
        $postsDao = new PostsDAO($db);
        return $postsDao->getPostsCountByUserId($userId);
    }

    public static function getPostsByUserId(string $userId): array {
        $db = PDOFactory::getPDOInstance();
        $postsDao = new PostsDAO($db);
        return $postsDao->getPostsByUserId($userId);
    }
}
