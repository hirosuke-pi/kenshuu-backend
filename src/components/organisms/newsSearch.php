<?php

class NewsSearch {
    /**
     * ニュース検索用コンポーネントをレンダリング
     *
     * @param array $posts ニュースの配列
     * @return void
     */
    public static function render(array $posts): void {
        $word = $_GET['word'] ?? '';
        ?>
            <aside class="w-full my-2">
                <section class="rounded-lg p-5 mt-3">
                    <form method="/">   
                        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="search" id="default-search" name="word" value="<?=convertSpecialCharsToHtmlEntities($word) ?>" class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:border-gray-300" placeholder="検索ワード">
                            <button type="submit" class="text-white absolute right-2.5 bottom-2.5 bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">
                                検索
                            </button>
                        </div>
                    </form>
                </section>
                <section class="rounded-lg p-5 mt-3">
                    <h3 class="text-xl text-gray-800 font-bold border-b border-gray-400">
                        <i class="fa-solid fa-newspaper"></i> ニュース検索: <?=count($posts)?>件
                    </h3>
                </section>
            </aside>
        <?php
    }
}
