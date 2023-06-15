<?php

class NewsSearch {
    /**
     * ニュース検索用コンポーネントをレンダリング
     *
     * @param array $posts ニュースの配列
     * @return void
     */
    public static function render(array $posts): void {
        ?>
            <aside class="w-full my-2">
                <section class="rounded-lg p-5 mt-3">
                    <h3 class="text-xl text-gray-800 font-bold border-b border-gray-400">
                        <i class="fa-solid fa-newspaper"></i> ニュース検索: <?=count($posts)?>件
                    </h3>
                </section>
            </aside>
        <?php
    }
}
