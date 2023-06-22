<?php

class NewsView {
    /**
     * 表示用のニュース記事コンポーネントをレンダリング
     *
     * @param PostsDTO $post ニュース投稿DTO
     * @return void
     */
    public static function render(PostsDTO $post) {
        $thumbnailPath = ImagesRepo::getThumbnailSrcByPostId($post->id);

        ?>
            <main class="rounded-lg border border-gray-300 m-3 overflow-hidden">
                <img class="w-full" src="<?=$thumbnailPath ?>" alt="news image">
                <article class="p-5">
                    <h2 class="text-4xl text-gray-800 font-bold mt-2 mb-2">
                        <?=convertSpecialCharsToHtmlEntities($post->title) ?>
                    </h2>
                    <hr/>
                    <section class="mt-2">
                        <div class="flex flex-wrap">
                            <p class="mx-2 mt-2 text-gray-700">
                                <i class="fa-regular fa-calendar"></i> <?=getDateTimeFormat($post->createdAt)?>
                            </p>
                            <?php if(isset($post->updatedAt)): ?>
                                <p class="mx-2 mt-2 text-gray-700">
                                    <i class="fa-solid fa-pen-to-square"></i> <?=getDateTimeFormat($post->updatedAt)?> (更新)
                                </p>
                            <?php endif; ?>
                        </div>
                        <iframe class="w-full" id="message" srcdoc="" scrolling="no" sandbox="allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>
                        <p id="message-raw" class="hidden">
<?=convertSpecialCharsToHtmlEntities($post->body) ?>
                        </p>
                    </section>
                </article>
                <script>
                    const rawMd = document.getElementById('message-raw').innerText
                    const md = DOMPurify.sanitize(marked.parse(rawMd));

                    const iframeElement = document.getElementById('message');
                    iframeElement.srcdoc = md.replaceAll('<a', '<a target="_blank" ');
                    iframeElement.addEventListener('load', () => {
                        iframeElement.style.height = (iframeElement.contentWindow.document.body.scrollHeight + 50) + 'px';
                    });
                </script>
            </main>
        <?php
    }
}
