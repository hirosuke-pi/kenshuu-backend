<?php

$newsEdit = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props) {
        $values->title = $props['title'];
        $values->body = $props['body'];

    },
    propTypes: ['title' => 'string', 'body' => 'string']
);

?>

<form action="/actions/news" method="POST">
    <div class="rounded-lg border border-gray-300 m-3 overflow-hidden">
        <img class="w-full" src="/img/news.jpg" alt="news image">
        <article class="p-5">
            <h2 class="text-4xl text-gray-800 font-bold mt-2 mb-2">
                <label for="default-input" class="block mb-2 mt-5 text-sm font-medium">タイトル</label>
                <input required value="<?=$newsEdit->values->title ?>" name="title" placeholder="タイトル" type="text" id="default-input" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </h2>
            <hr/>
            <section class="mt-2">
                <p class="text-gray-700 mt-5">
                    <label for="message" class="block mb-2 mt-5 text-sm font-medium">投稿内容</label>
                    <textarea required name="body" id="message" rows="10" class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="投稿内容">
                        <?=$newsEdit->values->body?>
                    </textarea>
                </p>
            </section>
        </article>
    </div>
    <?=ViewComponent::setCsrfToken()?>
</form>
