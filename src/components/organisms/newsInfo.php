<?php

[$badge] = ViewComponent::importAtoms(['badge']);
[$userInfo, $imageSelector] = ViewComponent::importMolecules(['userInfo', 'imageSelector']);

$newsInfo = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props) {
        $values->user = $props['user'];
        $values->isEditMode = in_array($props['mode'], [MODE_EDIT, MODE_CREATE]);

        $values->userInfoProps = [
            'id' => $values->user->id,
            'title' => '投稿者',
            'username' => $values->user->username,
            'postsCount' => $props['postsCount'],
            'visibleSettingButton' => false
        ];
    },
    propTypes: [
        'user' => 'object',
        'postsCount' => 'integer',
        'mode' => 'string'
    ]
);

?>

<aside class="w-full lg:w-80 m-3">
    <form id="image-tag">
        <?=$userInfo->view($newsInfo->rawValues->userInfoProps)?>
        <section class="border border-gray-300 rounded-lg p-5 mt-3">
            <h3 class="text-xl text-gray-800 font-bold border-b border-gray-400">
                <i class="fa-solid fa-tags"></i> タグ
            </h3>
            <?php if ($newsInfo->values->isEditMode): ?>
                <div class="mt-3 flex flex-wrap">
                    <div class="mx-3">
                        <input type="checkbox" name="tags" id="test1" value="test1"/> 
                        <label for="test1">タグ1</label>
                    </div>
                </div>
            <?php else: ?>
                <div class="mt-3 flex flex-wrap">
                    <?=$badge->view(['title' => 'テストバッジ1'])?>
                    <?=$badge->view(['title' => 'テストバッジ2'])?>
                    <?=$badge->view(['title' => 'テストバッジ3'])?>
                </div>
            <?php endif; ?>
        </section>
        <section class="border border-gray-300 rounded-lg p-5 mt-3">
            <h3 class="text-xl text-gray-800 font-bold border-b border-gray-400">
                <i class="fa-solid fa-images"></i> 画像一覧
            </h3>
            <div class="mt-5">
                <?php for($i = 0; $i < 3; $i++): ?>
                    <div class="mt-2 rounded-md overflow-hidden">
                        <?=$imageSelector->view(['name' => 'image'.$i, 'viewOnly' => !$newsInfo->values->isEditMode]) ?>
                    </div>
                <?php endfor; ?>
            </div>
        </section>
    </form>
</aside>
