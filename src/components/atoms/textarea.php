<?php

$textarea = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props) {
        $values->text = $props['text'];
    },
    propTypes: ['text' => 'string']
);

?>

<label for="message" class="block mb-2 mt-5 text-sm font-medium">投稿内容</label>
<textarea required name="body" id="message" rows="10" class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="投稿内容">
    <?=$textarea->values->text?>
</textarea>
