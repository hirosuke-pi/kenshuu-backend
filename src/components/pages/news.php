<?php

session_start();
$head = Component::viewTemplate('head');
$header = Component::viewTemplate('header');
$footer = Component::viewTemplate('footer');
$end = Component::viewTemplate('end');

$newsDetail = Component::viewOrganism('newsDetail');
$postInfo = Component::viewOrganism('postInfo');
?>

<?=$head->view(['title' => 'Flash News - '])?>
    <body>
        <?=$header->view()?>
        <section class="flex justify-center flex-wrap">
            <?=$newsDetail->view()?>
            <?=$postInfo->view()?>
        </section>
        <?=$footer->view()?>
    </body>
<?=$end->view()?>
