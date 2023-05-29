<?php

$badge = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props): void {
        $values->title = $props['title'];
    },
    propTypes: [
        'title' => 'string'
    ]
);

?>

<span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
    <i class="fa-solid fa-tag"></i> <?=$badge->values->title?>
</span>
