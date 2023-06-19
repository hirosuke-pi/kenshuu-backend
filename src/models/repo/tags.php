<?php

class TagsRepo {
    /**
     * タグを取得
     *
     * @param ?PDO $pdo PDOインスタンス
     * @return array タグの配列
     */
    public static function getTags(PDO $pdo = null): array {
        if (is_null($pdo)) $pdo = PDOFactory::getPDOInstance();
        $tagsDao = new TagsDAO($pdo);

        return $tagsDao->getTags();
    }

    /**
     * タグを取得 (投稿ID指定)
     *
     * @param int $postId 投稿ID
     * @param ?PDO $pdo PDOインスタンス
     * @return array タグの配列
     */
    public static function getTagsByPostId(string $postId, PDO $pdo = null): array {
        if (is_null($pdo)) $pdo = PDOFactory::getPDOInstance();
        $tagsDao = new TagsDAO($pdo);

        return $tagsDao->getTagsByPostId($postId);
    }

    /**
     * タグを追加 (投稿ID指定)
     *
     * @param array $tags タグの配列
     * @param string $postId 投稿ID
     * @param ?PDO $pdo PDOインスタンス
     * @return void
     */
    public static function addTagsByPostId(array $tags, string $postId, PDO $pdo = null): void {
        if (is_null($pdo)) $pdo = PDOFactory::getPDOInstance();
        $tagsDao = new TagsDAO($pdo);

        foreach($tags as $tag) {
            $tagsDao->addTagByPostId($tag, $postId);
        }
    }
}
