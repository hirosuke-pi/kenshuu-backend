<?php

require_once __DIR__ .'/../atoms/badge.php';

class TagCheckbox {
    /**
     * ニュースに付与されているタグリストや、全体のタグをチェックボックス・バッジでレンダリング
     *
     * @param boolean $enable チェックボックスを有効にするかどうか
     * @param string|null $postId 投稿ID　ない場合は全体のタグを取得
     * @return void
     */
    public static function render(bool $enable, ?string $postId = null): void {
        $db = PDOFactory::getNewPDOInstance();
        $tagsDao = new TagsDAO($db);

        $tags = [];
        if (is_null($postId)) {
            $tags = $tagsDao->getTags();
        } else {
            $tags = $tagsDao->getTagsByPostId($postId);
        }

        ?>
            <?php if($enable): ?>
                <?php foreach($tags as $tag): ?>
                    <div class="mx-3 my-1">
                        <input id="tag<?=$tag->id ?>" name="tags[]" value="<?=$tag->id ?>" class="tag-input" type="checkbox">
                        <label for="tag<?=$tag->id ?>"><?=convertSpecialCharsToHtmlEntities($tag->tagName) ?></label>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <?php foreach($tags as $tag): ?>
                    <?php Badge::render($tag->tagName) ?>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php
    }
}
