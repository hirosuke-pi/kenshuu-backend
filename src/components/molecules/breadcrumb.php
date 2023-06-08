<?php

class Breadcrumb {
    /**
     * 現在いる位置をレンダリング
     *
     * @param array $paths [['link' => 'https://example.com', 'name' => 'ホーム'], ...] の形式
     * @return void
     */
    public static function render(array $paths): void {
        ?>
            <div class="flex items-center text-gray-700">
                <a class="ml-1 mr-3 hover:underline " href="/" class="hover:underline">
                    <i class="fa-solid fa-house"></i> ホーム
                </a>
                <?php foreach($paths as $path): ?>
                    <i class="fa-solid fa-greater-than"></i>
                    <a class="mx-3 hover:underline" href="<?=$path['link'] ?>" class="text-gray-700 hover:underline">
                        <i class="fa-regular fa-file-lines"></i> <?=convertSpecialCharsToHtmlEntities($path['name']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php
    }
}
