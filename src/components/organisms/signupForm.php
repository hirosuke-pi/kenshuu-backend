<?php


require_once __DIR__ .'/../molecules/breadcrumb.php';
require_once __DIR__ .'/../molecules/alertSession.php';

require_once __DIR__ .'/../atoms/selectImage.php';

class SignupForm {
    public static function render() {
        $email = PageController::getRedirectData()['email'] ?? '';
        $breadcrumbProps = [
            ['name' => '新規登録', 'link' => $_SERVER['REQUEST_URI']]
        ];

        ?>
            <main class="w-full max-w-md mx-2">
                <div class="mt-3 p-2">
                    <?=Breadcrumb::render($breadcrumbProps)?>
                </div>
                <div class="my-3">
                    <?=AlertSession::render() ?>
                </div>
                <form action="/actions/login.php" method="POST">
                    <div class="bg-white border border-gray-300 rounded px-8 pt-6 pb-8 mb-4 flex flex-col">
                        <div class="mb-4">
                            <label class="block text-grey-darker text-sm font-bold mb-2" for="username">
                                ユーザー名
                            </label>
                            <input class="border border-gray-200 appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="username" name="username" type="text" value="<?=convertSpecialCharsToHtmlEntities($email) ?>" placeholder="User Name">
                        </div>
                        <div class="mb-4">
                            <label class="block text-grey-darker text-sm font-bold mb-2" for="email">
                                メールアドレス
                            </label>
                            <input class="border border-gray-200 appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="email" name="email" type="email" value="<?=convertSpecialCharsToHtmlEntities($email) ?>" placeholder="test@test.com">
                        </div>
                        <div class="mb-2">
                            <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                                パスワード
                            </label>
                            <input class="border border-gray-200 appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3" id="password" name="password" type="password">
                        </div>
                        <div class="mb-6">
                            <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                                プロフィール画像
                            </label>
                            <div class="rounded-md overflow-hidden">
                                <?php SelectImage::render('profile-image') ?>
                            </div>
                        </div>
                        <div class="flex items-center justify-center">
                            <button class="bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded w-full">
                                <i class="fa-solid fa-user-plus"></i> ユーザーを登録
                            </button>
                        </div>
                    </div>
                    <?php PageController::setCsrfToken(CSRF_LOGIN) ?>
                </form>
            </main>
        <?php
    }
}
