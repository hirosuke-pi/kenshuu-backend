<?php

[$newsEdit, $newsView] = ViewComponent::importMolecules(['newsEdit', 'newsView']);
[$breadcrumb, $userInfo] = ViewComponent::importMolecules(['breadcrumb', 'userInfo']);

$newsDetail = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props) {
        $values->userInfoProps = [
            'title' => 'ユーザー',
            'id' => $props['id'],
            'username' => $props['name'],
            'postsCount' => $props['postsCount'],
            'visibleSettingButton' => true
        ];
    },
    propTypes: ['id' => 'string', 'name' => 'string', 'postsCount' => 'integer']
);

?>

<aside class="w-full lg:w-80 m-3">
    <?=$userInfo->view($newsDetail->rawValues->userInfoProps)?>
    <section class="border border-gray-300 rounded-lg p-5 mt-3">
        <h3 class="text-xl text-gray-800 font-bold border-b border-gray-400">
            <i class="fa-solid fa-newspaper"></i> ニュース
        </h3>
        <div class="mt-3 flex flex-col">
            <a href="/news/post.php" class="w-full bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded mr-3 text-center mt-3">
                <i class="fa-solid fa-pen-to-square"></i> 新規作成
            </a>
        </div>
    </section>
</aside>
