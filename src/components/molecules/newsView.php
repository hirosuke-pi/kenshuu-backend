<?php

$newsView = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props) {
        $values->title = $props['title'];
        $values->body = $props['body'];
        $values->createdAt = $props['createdAt'];

        if (isset($props['updatedAt'])) {
            $values->updatedAt = $props['updatedAt'];
        }
        else {
            $values->updatedAt = null;
        }
    },
    propTypes: ['title' => 'string', 'body' => 'string', 'createdAt' => 'string']
);

?>

<main class="rounded-lg border border-gray-300 m-3 overflow-hidden">
    <img class="w-full" src="/img/news.jpg" alt="news image">
    <article class="p-5">
        <h2 class="text-4xl text-gray-800 font-bold mt-2 mb-2">
            <?=$newsView->values->title ?>
        </h2>
        <hr/>
        <section class="mt-2">
            <div class="flex flex-wrap">
                <p class="mx-2 mt-2 text-gray-700">
                    <i class="fa-regular fa-calendar"></i> <?=getDateTimeFormat($newsView->values->createdAt)?>
                </p>
                <?php if($newsView->values->updatedAt !== ''): ?>
                    <p class="mx-2 mt-2 text-gray-700">
                        <i class="fa-solid fa-pen-to-square"></i> <?=getDateTimeFormat($newsView->values->updatedAt)?> (更新)
                    </p>
                <?php endif; ?>
            </div>
            <p class="text-gray-700 mt-8">
                <?=replaceBr($newsView->values->body) ?>
            </p>
        </section>
    </article>
</main>
