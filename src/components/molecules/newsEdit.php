<?php

[$imagePreview] = ViewComponent::importMolecules(['imagePreview']);

$newsEdit = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props) {
        $values->title = $props['title'];
        $values->body = $props['body'];
        $values->id = $props['newsId'];
        $values->isEditMode = $props['mode'] === MODE_EDIT;
    },
    propTypes: ['mode' => 'string', 'title' => 'string', 'body' => 'string', 'newsId' => 'string']
);
$newsEditUrl = '/actions/news.php?id='. $newsEdit->values->id;

?>

<form action="<?=$newsEditUrl ?>" method="POST" onSubmit="return confirm('この内容でニュースをアップロードしますか？')" enctype="multipart/form-data" >
    <div class="rounded-lg border border-gray-300 m-3 overflow-hidden relative">
        <?=$imagePreview->view(['name' => 'thumbnail']) ?>
        <article class="p-5">
            <h2 class="text-4xl text-gray-800 font-bold mt-2 mb-2">
                <label for="default-input" class="block mb-2 mt-5 text-sm font-medium">タイトル</label>
                <input required value="<?=$newsEdit->values->title ?>" name="title" placeholder="タイトル" type="text" id="default-input" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </h2>
            <hr/>
            <section class="mt-2">
                <p class="text-gray-700 mt-5">
                    <label for="message" class="block mb-2 mt-5 text-sm font-medium">投稿内容</label>
                    <textarea required name="body" id="message" rows="10" class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="投稿内容"><?=$newsEdit->values->body?></textarea>
                </p>
            </section>
        </article>
    </div>
    <input id="thumbnail" name="thumbnail" type="file" class="hidden" accept="image/*"/>
    <?=ViewComponent::setCsrfToken()?>
    <?php if ($newsEdit->values->isEditMode) ViewComponent::setPutMethod() ?>
    <div class="p-3">
        <button class="w-full bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded ">
            <?php if($newsEdit->values->isEditMode): ?>
                <i class="fa-solid fa-rotate-right"></i> ニュースを更新
            <?php else: ?>
                <i class="fa-solid fa-plus"></i> ニュースを作成
            <?php endif; ?>
        </button>
    </div>
</form>
