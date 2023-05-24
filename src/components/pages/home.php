<?php

session_start();
[$head, $header, $footer, $end] = ViewComponent::importTemplates(['head', 'header', 'footer', 'end']);
[$newsList, $postForm] = ViewComponent::importOrganisms(['newsList', 'postForm']);

?>

<?=$head->view(['title' => 'Flash News'])?>
    <body>
        <?=$header->view()?>
        <?=$newsList->view()?>
        <hr class="ml-3 mr-3 mt-5">
        <?=$postForm->view()?>
        <?=$footer->view()?>
    </body>
<?=$end->view()?>
