<?php

$component = new Component($_PROPS, function ($props) {
    return [
        'title' => $props['title']
    ];
}, ['title' => 'string']);

$title = $component->values['title'];

?>

<span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
    <i class="fa-solid fa-tag"></i> <?=$title?>
</span>
