<?php

session_start();
$head = Component::viewTemplate('head');
$header = Component::viewTemplate('header');
$footer = Component::viewTemplate('footer');
$end = Component::viewTemplate('end');

$newsList = Component::viewOrganism('newsList');
$postForm = Component::viewOrganism('postForm');
?>

<?=$head->view(['title' => 'index'])?>
    <body>
        <?=$header->view()?>
        <?=$newsList->view()?>
        <hr class="ml-3 mr-3 mt-5">
        <?=$postForm->view()?>
        <?=$footer->view()?>
    </body>
<?=$end->view()?>
