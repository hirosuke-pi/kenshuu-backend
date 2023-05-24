<?php

$error = Component::viewOrganism('error');

$component = new Component(
    $_PROPS,
    function($props) {
        return [
            'post' => $props['post']
        ];
    },
    ['post' => 'array']
);

$post = $component->values['post'];

?>

<?php if (isset($component->values['post'])) { ?>
    <main class="w-6/3">
        <div>
            <h1 class="text-3xl font-bold text-center"><?=$post['title']?></h1>
            <p class="text-center text-gray-500">投稿者: <?=$post['userId']?></p>
            <p class="text-center text-gray-500">投稿日: <?=$post['createdAt']?></p>
            <p class="text-center text-gray-500">更新日: <?=$post['updatedAt']?></p>
            <p class="text-center text-gray-500">削除日: <?=$post['deletedAt']?></p>
            <p class="text-center text-gray-500">ID: <?=$post['id']?></p>
            <p class="text-center text-gray-500">本文: <?=$post['body']?></p>
        </div>
    </main>
<?php } else { ?>
    <?=$error->view(['message' => '投稿が見つかりませんでした'])?>
<?php } ?>
