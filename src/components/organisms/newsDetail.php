<?php

require_once __DIR__ .'/breadcrumb.php';

class NewsDetail {
    public static function render(PostsDTO $post): void {
        $props = [['name' => 'ニュース - '. $post->title, 'link' => $_SERVER['REQUEST_URI']]];

        ?>
            <div class="w-full lg:w-3/6 ">
                <div class="m-3 p-2 rounded-lg">
                    <?=Breadcrumb::render($props)?>
                </div>
                <main class="rounded-lg border border-gray-300 m-3 overflow-hidden">
                    <img class="w-full" src="/img/news.jpg" alt="news image">
                    <article class="p-5">
                        <h2 class="text-4xl text-gray-800 font-bold mt-2 mb-2"><i class="fa-solid fa-newspaper"></i> <?=h($post->title) ?></h2>
                        <hr/>
                        <section class="mt-2">
                            <p class="text-gray-700"><i class="fa-regular fa-calendar"></i> <?=getDateTimeFormat(h($post->createdAt)) ?></p>
                            <p class="text-gray-700 mt-5"><?=h($post->body) ?></p>
                        </section>
                    </article>
                </main>
            </div>
        <?php
    }
}
