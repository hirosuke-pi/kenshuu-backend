<?php

$c = new Component($_PROPS, function ($props) {
    return [
        'title' => $props['title']
    ];
}, ['title' => 'string']);

?>

<span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
    <?=$c->values['title']?>
</span>
