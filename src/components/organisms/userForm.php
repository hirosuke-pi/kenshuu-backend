<?php


require_once __DIR__ .'/../molecules/breadcrumb.php';
require_once __DIR__ .'/../molecules/alertSession.php';

require_once __DIR__ .'/../atoms/selectImage.php';

class UserForm {
    public static function render(UsersDTO $user = null) {
        $data = PageController::getRedirectData();

        [
            $email,
            $username,
            $userPutMode,
            $maxSize,
            $breadcrumbProps
        ] = match($user) {
            null => [
                $data['email'] ?? '',
                $data['username'] ?? '',
                false,
                'max-w-md',
                [['name' => '新規登録', 'link' => $_SERVER['REQUEST_URI']]]
            ],
            default => [
                $user->email,
                $user->username,
                true,
                'max-w-2xl',
                [
                    ['name' => 'ユーザー - @'. $user->username, 'link' => '/user/index.php?id='. $user->id],
                    ['name' => 'ユーザー設定', 'link' => $_SERVER['REQUEST_URI']]
                ]
            ]
        };

        ?>
            <main class="w-full <?=$maxSize ?> mx-2">
                <div class="mt-3 p-2">
                    <?php Breadcrumb::render($breadcrumbProps)?>
                </div>
                <div class="my-3">
                    <?php AlertSession::render() ?>
                </div>
                <form action="/actions/user.php" method="POST" enctype="multipart/form-data">
                    <div class="bg-white border border-gray-300 rounded px-8 pt-6 pb-8 mb-4 flex flex-col">
                        <div class="mb-4">
                            <label class="block text-grey-darker text-sm font-bold mb-2" for="username">
                                ユーザー名
                            </label>
                            <input class="border border-gray-200 appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="username" name="username" type="text" value="<?=convertSpecialCharsToHtmlEntities($username) ?>" placeholder="User Name">
                        </div>
                        <div class="mb-4">
                            <label class="block text-grey-darker text-sm font-bold mb-2" for="email">
                                メールアドレス
                            </label>
                            <input class="border border-gray-200 appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="email" name="email" type="email" value="<?=convertSpecialCharsToHtmlEntities($email) ?>" placeholder="test@test.com">
                        </div>
                        <div class="mb-2">
                            <label class="block text-grey-darker text-sm font-bold mb-2" for="password1">
                                パスワード
                            </label>
                            <input class="border border-gray-200 appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3" id="password1" name="password1" type="password">
                        </div>
                        <div class="mb-2">
                            <label class="block text-grey-darker text-sm font-bold mb-2" for="password2">
                                確認用パスワード
                            </label>
                            <input class="border border-gray-200 appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3" id="password2" name="password2" type="password">
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
                                <?php if ($userPutMode) : ?>
                                    <i class="fa-solid fa-user-edit"></i> ユーザーを更新
                                <?php else : ?>
                                    <i class="fa-solid fa-user-plus"></i> ユーザーを登録
                                <?php endif; ?>
                            </button>
                        </div>
                    </div>
                    <?php PageController::setCsrfToken(CSRF_SIGNUP) ?>
                    <?php if ($userPutMode) PageController::setPutMethod(); ?>
                </form>
            </main>
        <?php
    }
}
