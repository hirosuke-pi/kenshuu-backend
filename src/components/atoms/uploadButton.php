<?php

$c = new Component($_PROPS, function (array $props) {
    return [
        'text' => $props['text'],
    ];
}, ['title' => 'string']);

?>

<Button class="btn btn-blue">
    <?=$c->values['text']?>
</Button>
