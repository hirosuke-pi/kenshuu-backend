<?php

require_once '../functions/component.php';
$comp = Component::viewAtom('test', ['test'=> 'aaa']);

// TODO: cssはどうするか

?>

<div>
    <h1>main</h1>
    <?=$comp->view()?>
    <?=$comp->view()?>
</div>

