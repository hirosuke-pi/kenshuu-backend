<?php

PageController::sessionStart();
[$head, $header, $footer, $end] = ViewComponent::importTemplates(['head', 'header', 'footer', 'end']);
[$newsList, $postForm] = ViewComponent::importOrganisms(['newsList', 'postForm']);

$home = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props): void {
        $values->headProps = ['title' => 'Flash News'];
    }
);

?>

<?=$head->view($home->values->headProps)?>
    <body>
        <?=$header->view()?>
        <?=$newsList->view()?>
        <?=$footer->view()?>
    </body>
<?=$end->view()?>
