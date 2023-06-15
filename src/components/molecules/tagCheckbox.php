<?php

require_once __DIR__ .'/../atoms/badge.php';

class TagCheckbox {
    /**
     * タグリストを表示する
     *
     * @param array $tags タグリスト
     * @param boolean $enable チェックボックスを表示するかどうか
     * @return void
     */
    public static function render(array $tags, bool $enable): void {
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
