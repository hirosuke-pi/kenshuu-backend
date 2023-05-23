<?php

$c = new Component($_PROPS, function (array $props) {
    $csrf_token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $csrf_token;

    return [
        'csrf_token' => $csrf_token,
    ];
});

?>

<form class="flex flexjustify-center items-center flex-col" method="POST" action="/actions/news.php?test=aaaaa">
    <div class="w-4/5">
        <label for="default-input" class="block mb-2 mt-5 text-sm font-medium">タイトル</label>
        <input name="title" placeholder="タイトル" type="text" id="default-input" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        <label for="message" class="block mb-2 mt-5 text-sm font-medium">投稿内容</label>
        <textarea name="body" id="message" rows="10" class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="投稿内容"></textarea>

        <input name="_method" type="hidden" value="PUT" />
        <input name="csrf_token" type="hidden" value="<?=$c->values['csrf_token']?>" />
        <button class="mt-5 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            投稿
        </button>
    </div>    
</form>
