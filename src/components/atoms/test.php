<?php

$component = new Component(function (array $props) {
    return [
        'test' => $props['test']
    ];
}, ['test' => 'string']);
?>

<p><?=$component->values['test']?></p>
