<?php

class NewsActions {
    /**
     * 管理者用操作メニューをレンダリング
     *
     * @param string $postId 操作するニュースID
     * @return void
     */
    public static function render(string $postId) {
        $editUrl = './edit.php?id='. $postId;
        $deleteUrl = '/actions/news.php?id='. $postId;

        ?>
            <div class="rounded-lg border border-gray-300 m-3 overflow-hidden p-5">
                <h3 class="text-xl text-gray-800 font-bold border-b border-gray-400">
                    <i class="fa-solid fa-user-gear"></i> 管理ユーザー操作
                </h3>
                <div class="flex flex-wrap mt-3">
                    <a href="<?=$editUrl?>" class="bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded mr-3">
                        <i class="fa-solid fa-pen-to-square"></i> ページを編集
                    </a>
                    <form action="<?=$deleteUrl ?>" method="POST" onSubmit="return confirm('この操作は取り消せません。本当に削除しますか?') ">
                        <button  class="bg-red-400 hover:bg-red-500 text-white font-bold py-2 px-4 rounded ">
                            <i class="fa-solid fa-trash"></i> ページを削除
                        </button>
                        <?php PageController::setCsrfToken() ?>
                        <?php PageController::setDeleteMethod() ?>
                    </form>
                </div>
            </div>
        <?php
    }
}
