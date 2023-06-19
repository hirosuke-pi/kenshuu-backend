<?php

require_once __DIR__ .'/../atoms/selectImage.php';

class NewsEdit {
    /**
     * ニュース編集フォームをレンダリング
     *
     * @param ?PostsDTO $post ニュースDTO
     * @param NewsMode $mode ニュースの表示モード
     * @return void
     */
    public static function render(?PostsDTO $post, NewsMode $mode): void {
        [$newsEditUrl, $isEditMode, $thumbnailPath] = match($mode) {
            NewsMode::EDIT => [
                '/actions/news.php?id='. $post->id,
                true,
                ImagesRepo::getThumbnailSrcByPostId($post->id)
            ],
            default => [
                '/actions/news.php',
                false,
                DEFAULT_THUMBNAIL
            ]
        };

        $title = $post->title ?? '';
        $body = $post->body ?? '';

        ?>
            <form id="newsForm" action="<?=$newsEditUrl ?>" method="POST" enctype="multipart/form-data">
                <div class="rounded-lg border border-gray-300 m-3 overflow-hidden">
                    <?php if($isEditMode): ?>
                        <img class="w-full" src="<?=$thumbnailPath?>" alt="news image">
                    <?php else: ?>
                        <?php SelectImage::render('thumbnail') ?>
                    <?php endif; ?>
                    <article class="p-5">
                        <h2 class="text-4xl text-gray-800 font-bold mt-2 mb-2">
                            <label for="default-input" class="block mb-2 mt-5 text-sm font-medium">タイトル</label>
                            <input value="<?=convertSpecialCharsToHtmlEntities($title) ?>" name="title" placeholder="タイトル" type="text" id="default-input" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </h2>
                        <section class="mt-2">
                            <p class="text-gray-700 mt-5">
                                <label for="message" class="block mb-2 mt-5 text-sm font-medium">投稿内容</label>
                                <textarea name="body" id="message" rows="10" class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="投稿内容"><?=convertSpecialCharsToHtmlEntities($body) ?></textarea>
                            </p>
                        </section>
                    </article>
                </div>
                <div class="p-3">
                    <button class="w-full bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded ">
                        <?php if($isEditMode): ?>
                            <i class="fa-solid fa-rotate-right"></i> ニュースを更新
                        <?php else: ?>
                            <i class="fa-solid fa-plus"></i> ニュースを作成
                        <?php endif; ?>
                    </button>
                </div>
                <?php 
                    if ($isEditMode) {
                        PageController::setPutMethod();
                        PageController::setCsrfToken(CSRF_NEWS_EDIT);
                    }
                    else {
                        PageController::setCsrfToken(CSRF_NEWS_CREATE);
                    }
                ?>
            </form>
            <script>
                const easyMDE = new EasyMDE({
                    spellChecker: false,
                    hideIcons: ['guide', 'preview', 'side-by-side'],
                });
                document.getElementById('newsForm').addEventListener('formdata', (event) => {
                    document.querySelectorAll('.image-input').forEach((element) => {
                        if (!element?.files?.[0]) return;
                        event.formData.append(element.name, element.files[0]);
                    });
                    document.querySelectorAll('.tag-input').forEach((element) => {
                        if (!element.checked) return;
                        event.formData.append(element.name, element.value);
                    });
                });
            </script>
        <?php
    }
}
