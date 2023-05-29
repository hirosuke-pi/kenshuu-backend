<?php

[$newsEdit, $newsView] = ViewComponent::importMolecules(['newsEdit', 'newsView']);
[$breadcrumb, $newsActions] = ViewComponent::importMolecules(['breadcrumb', 'newsActions']);

$newsDetail = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props) {
        $post = $props['post'];

        $values->editorMode = in_array($props['mode'], [MODE_EDIT, MODE_NEW]);

        $values->newsTitleBodyProps = [
            'title' => $post->title,
            'body' => $post->body,
            'createdAt' => $post->createdAt,
            'updatedAt' => $post->updatedAt,
            'newsId' => $post->id
        ];
        $values->newsActionsProps = [
            'newsId' => $post->id,
            'mode' => $props['mode']
        ];

        if ($values->editorMode) {
            $values->breadcrumbProps = [
                'paths' => [
                    ['name' => 'ニュース - '. $post->title, 'link' => 'index.php?id='. $post->id],
                    ['name' => 'ページを編集', 'link' => $_SERVER['REQUEST_URI']],
                ]
            ];
        }
        else {
            $values->breadcrumbProps = [
                'paths' => [
                    ['name' => 'ニュース - '. $post->title, 'link' => $_SERVER['REQUEST_URI']]
                ]
            ];
        }
    },
    propTypes: ['post' => 'object', 'mode' => 'string']
);

?>

<div class="w-full lg:w-3/6 ">
    <div class="m-3 p-2">
        <?=$breadcrumb->view($newsDetail->values->breadcrumbProps)?>
    </div>
    <?php if ($newsDetail->values->editorMode): ?>
        <?=$newsEdit->view(props: $newsDetail->rawValues->newsTitleBodyProps) ?>
    <?php else: ?>
        <?=$newsActions->view($newsDetail->values->newsActionsProps) ?>
        <?=$newsView->view($newsDetail->rawValues->newsTitleBodyProps) ?>
    <?php endif; ?>
</div>
