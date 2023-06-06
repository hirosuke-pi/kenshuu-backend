<?php

class Header {
    /**
     * ヘッダーをレンダリング
     *
     * @return void
     */
    public static function render(): void {
        $db = PDOFactory::getNewPDOInstance();
        $usersDao = new UsersDAO($db);
        
        $user = $usersDao->getUserByEmail('test@test.com');
        $userUrl = '/user/index.php?id='. $user->id;

        ?>
            <header class="flex justify-center mt-10 mb-3">
                <div class="flex justify-between w-9/12 flex-wrap">
                    <a href="/" class="text-gray-800 group">
                        <h1 class="text-6xl font-bold">
                            <i class="fa-solid fa-bolt-lightning group-hover:text-yellow-400"></i> Flash News
                        </h1>
                    </a>
                    <div class="flex items-center text-gray-700 flex-wrap">
                        <a href="/actions/logout.php" class="hover:bg-gray-200 rounded-lg p-2 mr-4 mt-3 ">
                            <i class="fa-solid fa-right-from-bracket"></i> ログアウト
                        </a>
                        <a href="<?=$userUrl ?>" class="flex items-center py-2 px-4 hover:bg-gray-200 rounded-lg border border-gray-300 mt-3">
                            <img class="w-7 h-7 rounded-full object-cover mr-1" src="/img/news.jpg" alt="user image">
                            <p class="text-xl font-bold">@<?=h($user->username) ?></p>
                        </a>
                    </div>
                </div>
            </header>
            <hr class="ml-3 mr-3 mb-5"/>
        <?php
    }
}
