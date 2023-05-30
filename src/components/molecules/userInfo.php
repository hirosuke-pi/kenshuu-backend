<?php

$userInfo = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props): void {
        $values->id = $props['id'];
        $values->title = $props['title'];
        $values->username = $props['username'];
        $values->postsCount = $props['postsCount'];
        $values->visibleSettingButton = $props['visibleSettingButton'];
    },
    propTypes: [
        'id' => 'string',
        'title' => 'string',
        'username' => 'string',
        'postsCount' => 'integer',
        'visibleSettingButton' => 'boolean'
    ]
);

$userUrl = '/user/index.php?id='. $userInfo->values->id;

?>

<section class="bg-gray-100 border border-gray-300 rounded-lg p-5">
    <h3 class="text-xl text-gray-800 font-bold border-b border-gray-400">
        <i class="fa-solid fa-user"></i> <?=$userInfo->values->title ?>
    </h3>
    <div class="mt-3 flex justify-center items-center flex-col">
        <a href="<?=$userUrl ?>" class="hover:underline">
            <img class="w-20 h-20 rounded-full object-cover" src="/img/news.jpg" alt="user image">
            <p class="text-xl font-bold text-gray-700 text-center">@<?=$userInfo->values->username ?></p>
        </a>
        <p class="text-gray-600 mt-2">記事投稿数: <strong><?=$userInfo->values->postsCount ?></strong></p>
        <?php if ($userInfo->values->visibleSettingButton): ?>
            <a href="/user/settings.php" class="w-full border border-gray-400 hover:bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded text-center mt-3">
                <i class="fa-solid fa-user-gear"></i> ユーザー設定
            </a>
        <?php endif; ?>
    </div>
</section>
