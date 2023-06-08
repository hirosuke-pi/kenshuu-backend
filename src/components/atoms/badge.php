<?php

class Badge {
    /**
     * バッジをレンダリング
     *
     * @param string $title バッジのタイトル
     * @return void
     */
    public static function render(string $title): void {
        ?>
            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                <i class="fa-solid fa-tag"></i> <?=convertSpecialCharsToHtmlEntities($title)?>
            </span>
        <?php
    }
}
