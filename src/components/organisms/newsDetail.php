<?php

[$breadcrumb] = ViewComponent::importOrganisms(['breadcrumb']);

$component = new Component(
    $_PROPS,
    function($props) {
        return [
            'post' => $props['post'],
            'paths' => [
                ['name' => 'ニュース - '. $props['post']->title, 'link' => $_SERVER['REQUEST_URI']],
            ]
        ];
    },
    ['post' => 'object']
);

$breadcrumbProps = ['paths' => $component->rawValues['paths']];
$post = $component->values['post'];

?>

<div class="w-full lg:w-3/6 ">
    <div class="m-3 p-2 rounded-lg">
        <?=$breadcrumb->view($breadcrumbProps)?>
    </div>
    <main class="rounded-lg border border-gray-300 m-3 overflow-hidden">
        <img class="w-full" src="/img/news.jpg" alt="news image">
        <article class="p-5">
            <h2 class="text-4xl text-gray-800 font-bold mt-2 mb-2"><i class="fa-solid fa-newspaper"></i> <?=$post['title']?></h2>
            <hr/>
            <section class="mt-2">
                <p class="text-gray-700"><i class="fa-regular fa-calendar"></i> <?=getDateTimeFormat($post['createdAt'])?></p>
                <p class="text-gray-700 mt-5"><?=$post['body']?></p>
            </section>
        </article>
    </main>
</div>
