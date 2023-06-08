<?php

class NewsView {
    /**
     * 表示用のニュース記事コンポーネントをレンダリング
     *
     * @param PostsDTO $post ニュース投稿DTO
     * @return void
     */
    public static function render(PostsDTO $post) {
        ?>
            <main class="rounded-lg border border-gray-300 m-3 overflow-hidden">
                <img class="w-full" src="/img/news.jpg" alt="news image">
                <article class="p-5">
                    <h2 class="text-4xl text-gray-800 font-bold mt-2 mb-2">
                        <?=convertSpecialCharsToHtmlEntities($post->title) ?>
                    </h2>
                    <hr/>
                    <section class="mt-2">
                        <div class="flex flex-wrap">
                            <p class="mx-2 mt-2 text-gray-700">
                                <i class="fa-regular fa-calendar"></i> <?=getDateTimeFormat($post->createdAt)?>
                            </p>
                            <?php if(isset($post->updatedAt)): ?>
                                <p class="mx-2 mt-2 text-gray-700">
                                    <i class="fa-solid fa-pen-to-square"></i> <?=getDateTimeFormat($post->updatedAt)?> (更新)
                                </p>
                            <?php endif; ?>
                        </div>
                        <p class="text-gray-700 mt-8">
                            <?=replaceBr(convertSpecialCharsToHtmlEntities($post->body)) ?>
                        </p>
                    </section>
                </article>
            </main>
        <?php
    }
}

?>
