<?php

[$badge] = ViewComponent::importAtoms(['badge']);

$newsCard = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props): void {
        if ($props['mode'] === 'card') {
            $values->cardSize = 'max-w-sm';
        }
        else {
            $values->cardSize = '';
        }

        $values->post = $props['post'];
    },
    propTypes: ['post' => 'object', 'mode' => 'string']
);

$card = $newsCard->values->post;
$newsLink = '/news/index.php?id='. $card['id'];

?>

<li class="m-3">
    <div class="<?=$newsCard->values->cardSize ?> rounded overflow-hidden shadow-md">
        <a href="<?=$newsLink ?>" class="">
            <img class="w-full" src="/img/news.jpg" alt="news image">
        </a>
        <div class="px-6 py-4">
            <a href="<?=$newsLink ?>" class="hover:underline hover:text-gray-500">
                <h3 class="font-bold text-xl mb-2"><?=$card['title'] ?></h3>
            </a>
            <p class="text-gray-700 text-base ellipsis-line-3">
                <?=$card['body'] ?>
            </p>
            <?php if ($card['updatedAt']): ?>
                <p class="text-gray-700 text-base mt-4">
                    <i class="fa-solid fa-pen-to-square"></i> <?=getDateTimeFormat($card['updatedAt']) ?>
                </p>
            <?php else: ?>
                <p class="text-gray-700 text-base mt-4">
                    <i class="fa-regular fa-calendar"></i> <?=getDateTimeFormat($card['createdAt']) ?>
                </p>
            <?php endif; ?>
        </div>
        <hr class="ml-3 mr-3 mt-1 mb-1">
        <div class="px-6 pt-4 pb-2">
            <?=$badge->view(['title' => 'テストバッジ1'])?>
            <?=$badge->view(['title' => 'テストバッジ2'])?>
            <?=$badge->view(['title' => 'テストバッジ3'])?>
        </div>
    </div>
</li>
