<?php

class NewsEdit {
    /**
     * ニュース編集フォームをレンダリング
     *
     * @param ?PostsDTO $post ニュースDTO
     * @param string $mode 表示モードか、編集モードか (固定値: MODE_VIEW, MODE_EDIT, MODE_NEW)
     * @return void
     */
    public static function render(?PostsDTO $post, string $mode): void {
        $newsEditUrl = '/actions/news.php';
        $isEditMode = false;
        if ($mode === MODE_EDIT) {
            $newsEditUrl .= '?id='. $post->id;
            $isEditMode = true;
        }
        
        $title = $post->title ?? '';
        $body = $post->body ?? '';

        ?>
            <form action="<?=$newsEditUrl ?>" method="POST">
                <div class="rounded-lg border border-gray-300 m-3 overflow-hidden">
                    <img class="w-full" src="/img/news.jpg" alt="news image">
                    <article class="p-5">
                        <h2 class="text-4xl text-gray-800 font-bold mt-2 mb-2">
                            <label for="default-input" class="block mb-2 mt-5 text-sm font-medium">タイトル</label>
                            <input required value="<?=convertSpecialCharsToHtmlEntities($title) ?>" name="title" placeholder="タイトル" type="text" id="default-input" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </h2>
                        <hr/>
                        <section class="mt-2">
                            <p class="text-gray-700 mt-5">
                                <label for="message" class="block mb-2 mt-5 text-sm font-medium">投稿内容</label>
                                <textarea required name="body" id="message" rows="10" class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="投稿内容"><?=convertSpecialCharsToHtmlEntities($body) ?></textarea>
                            </p>
                        </section>
                        <section class="mt-3">
                            <button  class="w-full bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded ">
                                <?php if($isEditMode): ?>
                                    <i class="fa-solid fa-rotate-right"></i> ニュースを更新
                                <?php else: ?>
                                    <i class="fa-solid fa-plus"></i> ニュースを作成
                                <?php endif; ?>
                            </button>
                        </section>
                    </article>
                </div>
                <?php PageController::setCsrfToken() ?>
                <?php if ($isEditMode) PageController::setPutMethod() ?>
            </form>
        <?php
    }
}
