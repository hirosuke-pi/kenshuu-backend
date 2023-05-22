<?php

$head = Component::viewTemplate('head');
$footer = Component::viewTemplate('footer');

?>

<?=$head->view()?>
    <body>
        <h1 class="text-3xl font-bold underline">
            Hello world!
        </h1>
    </body>
<?=$footer->view()?>
