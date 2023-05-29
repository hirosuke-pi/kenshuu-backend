<?php

[$badge] = ViewComponent::importAtoms(['badge']);

$userInfo = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props) {
        $values->postsCount = $props['postsCount'];
        $values->user = $props['user'];
    },
    propTypes: [
        'user' => 'object',
        'postsCount' => 'integer'
    ]
);

$user = $userInfo->values->user;
$postsCount = $userInfo->values->postsCount;

?>

<aside class="w-full lg:w-80 m-3">
    <section class="bg-gray-100 border border-gray-300 rounded-lg p-5">
        <h3 class="text-xl text-gray-800 font-bold border-b border-gray-400">
            <i class="fa-solid fa-user"></i> 投稿者
        </h3>
        <div class="mt-3 flex justify-center items-center flex-col">
            <a href="#" class="hover:underline">
                <img class="w-20 h-20 rounded-full object-cover" src="/img/news.jpg" alt="user image">
                <p class="text-xl font-bold text-gray-700 text-center">@<?=$user['username']?></p>
            </a>
            <p class="text-gray-600 mt-2">記事投稿数: <strong><?=$postsCount ?></strong></p>
        </div>
    </section>
    <section class="border border-gray-300 rounded-lg p-5 mt-3">
        <h3 class="text-xl text-gray-800 font-bold border-b border-gray-400">
        <i class="fa-solid fa-tags"></i> タグ
        </h3>
        <div class="mt-3 flex flex-wrap">
            <?=$badge->view(['title' => 'テストバッジ1'])?>
            <?=$badge->view(['title' => 'テストバッジ2'])?>
            <?=$badge->view(['title' => 'テストバッジ3'])?>
        </div>
    </section>
    <section class="border border-gray-300 rounded-lg p-5 mt-3">
        <h3 class="text-xl text-gray-800 font-bold border-b border-gray-400">
            <i class="fa-solid fa-images"></i> 画像一覧
        </h3>
        <div class="mt-5">
            <img class="w-full rounded-lg my-2" src="/img/news.jpg" alt="news image">
            <img class="w-full rounded-lg my-2" src="/img/news.jpg" alt="news image">
            <img class="w-full rounded-lg my-2" src="/img/news.jpg" alt="news image">
        </div>
    </section>
</aside>
