<?php

$head = Component::viewTemplate('head', ['title' => 'index']);
$header = Component::viewTemplate('header');
$footer = Component::viewTemplate('footer');

$postForm = Component::viewOrganism('postForm');
?>

<?=$head->view()?>
    <body>
        <?=$header->view()?>
        <hr class="ml-3 mr-3 mt-5">
        <?=$postForm->view()?>
    </body>
<?=$footer->view()?>
