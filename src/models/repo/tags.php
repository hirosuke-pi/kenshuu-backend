<?php

class TagsRepo {
    /**
     * タグを取得
     *
     * @return array タグの配列
     */
    public static function getTags(): array {
        $db = PDOFactory::getPDOInstance();
        $tagsDao = new TagsDAO($db);

        return $tagsDao->getTags();
    }

    /**
     * タグを取得 (投稿ID指定)
     *
     * @param int $postId 投稿ID
     * @return array タグの配列
     */
    public static function getTagsByPostId(string $postId): array {
        $db = PDOFactory::getPDOInstance();
        $tagsDao = new TagsDAO($db);

        return $tagsDao->getTagsByPostId($postId);
    }
}
