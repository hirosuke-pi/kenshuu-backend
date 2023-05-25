<?php

$component = new Component(
    $_PROPS,
    function($props) {
        return [
            'post' => $props['post']
        ];
    },
    ['post' => 'object']
);

$post = $component->values['post'];

?>


<main class="w-full lg:w-3/6 rounded-lg border border-gray-300 m-3 overflow-hidden">
    <img class="w-full" src="/img/news.jpg" alt="news image">
    <article class="p-3">
        <h2 class="text-4xl text-gray-800 font-bold mt-2 mb-2"><?=$post['title']?></h2>
        <hr/>
        <section class="mt-2">
            <p class="text-gray-700">投稿日: <?=getDateTimeFormat($post['createdAt'])?></p>
            <p class="text-gray-700 mt-5"><?=$post['body']?></p>
        </section>
    </article>
</main>
