<?php

class NewsView {
    /**
     * ニュース表示用のコンポーネントをレンダリング
     *
     * @param string $title タイトル
     * @param string $body ニュース内容
     * @param string $createdAt 作成日時
     * @return void
     */
    public static function render(string $title, string $body, string $createdAt) {
        ?>
            <main class="rounded-lg border border-gray-300 m-3 overflow-hidden">
                <img class="w-full" src="/img/news.jpg" alt="news image">
                <article class="p-5">
                    <h2 class="text-4xl text-gray-800 font-bold mt-2 mb-2">
                        <?=convertSpecialCharsToHtmlEntities($title) ?>
                    </h2>
                    <hr/>
                    <section class="mt-2">
                        <p class="text-gray-700"><i class="fa-regular fa-calendar"></i> <?=getDateTimeFormat($createdAt)?></p>
                        <p class="text-gray-700 mt-5">
                            <?=replaceBr(convertSpecialCharsToHtmlEntities($body)) ?>
                        </p>
                    </section>
                </article>
            </main>
        <?php
    }
}

?>
