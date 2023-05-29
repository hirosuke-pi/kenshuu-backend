<?php

$textbox = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props) {
        $values->text = $props['text'];
    },
    propTypes: ['text' => 'string']
);

?>

<label for="default-input" class="block mb-2 mt-5 text-sm font-medium">タイトル</label>
<input required value="<?=$textbox->values->text ?>" name="title" placeholder="タイトル" type="text" id="default-input" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
