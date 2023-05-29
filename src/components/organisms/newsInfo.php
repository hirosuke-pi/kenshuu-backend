<?php

[$badge] = ViewComponent::importAtoms(['badge']);
[$userInfo] = ViewComponent::importMolecules(['userInfo']);

$newsInfo = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props) {
        $values->user = $props['user'];

        $values->userInfoProps = [
            'id' => $values->user->id,
            'title' => '投稿者',
            'username' => $values->user->username,
            'postsCount' => $props['postsCount'],
        ];
    },
    propTypes: [
        'user' => 'object',
        'postsCount' => 'integer'
    ]
);

?>

<aside class="w-full lg:w-80 m-3">
    <?=$userInfo->view($newsInfo->rawValues->userInfoProps)?>
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
