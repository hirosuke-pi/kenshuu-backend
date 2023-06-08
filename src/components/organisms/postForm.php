<?php

class PostForm {
    /**
     * ニュース投稿フォームをレンダリング
     *
     * @return void
     */
    public static function render(): void {
        ?>
            <form class="flex flexjustify-center items-center flex-col" method="POST" action="/actions/news.php?test=aaaaa">
                <div class="w-4/5">
                    <label for="default-input" class="block mb-2 mt-5 text-sm font-medium">タイトル</label>
                    <input required name="title" placeholder="タイトル" type="text" id="default-input" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <label for="message" class="block mb-2 mt-5 text-sm font-medium">投稿内容</label>
                    <textarea required name="body" id="message" rows="10" class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="投稿内容"></textarea>

                    <?php PageController::setCsrfToken()?>
                    <button class="mt-5 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        投稿
                    </button>
                </div>    
            </form>
        <?php
    }
}
