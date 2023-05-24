<?php

$badge = Component::viewAtom('badge');

$c = new Component($_PROPS, function($props) {
    return [
        'post' => $props['post']
    ];
}, ['post' => 'object']);

$item = $c->values['post'];
$newsLink = '/news/index.php?id='. $item['id'];

?>

<li class="m-3">
    <div class="max-w-sm rounded overflow-hidden shadow-md">
        <a href="<?=$newsLink ?>" class="">
            <img class="w-full" src="/img/news.jpg" alt="news image">
        </a>
        <div class="px-6 py-4">
            <a href="<?=$newsLink ?>" class="hover:underline hover:text-gray-500">
                <h3 class="font-bold text-xl mb-2"><?=$item['title'] ?></h3>
            </a>
            <p class="text-gray-700 text-base ellipsis-line-3">
                <?=$item['body'] ?>
            </p>
            <p class="text-gray-700 text-base mt-4">
                <?=getDateTimeFormat($item['createdAt']) ?>
            </p>
        </div>
        <hr class="ml-3 mr-3 mt-1 mb-1">
        <div class="px-6 pt-4 pb-2">
            <?=$badge->view(['title' => '#テストバッジ1'])?>
            <?=$badge->view(['title' => '#テストバッジ2'])?>
            <?=$badge->view(['title' => '#テストバッジ3'])?>
        </div>
    </div>
</li>
