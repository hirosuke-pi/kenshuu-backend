<?php

$component = new Component(
    $_PROPS,
    function($props) {
        return [
            'user' => $props['user']
        ];
    },
    ['user' => 'object']
);

$user = $component->values['user'];

?>


<aside class="w-full lg:w-80 m-3">
    <section class="bg-gray-200 rounded-lg p-5">
        <h3 class="text-xl text-gray-800 font-bold">
            投稿者
        </h3>
        <hr/>
    </section>
    <section class="bg-gray-200 rounded-lg p-5 mt-3">
        <h3 class="text-xl text-gray-800 font-bold">
            タグ
        </h3>
        </hr>
    </section>
    <section class="bg-gray-200 rounded-lg p-5 mt-3">
        <h3 class="text-xl text-gray-800 font-bold">
            画像一覧
        </h3>
        </hr>
    </section>
</aside>
