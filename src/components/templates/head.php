<?php
$component = new Component(
    $_PROPS, 
    function (array $props) {
        return [
            'title' => $props['title'],
        ];
    },
    ['title' => 'string']
);

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title><?=$component->values['title']?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
