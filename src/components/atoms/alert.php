<?php
enum AlertType {
    case ERROR;
    case SUCCESS;
    case INFO;
    case WARNING;
}

class Alert {
    /**
     * アラートをレンダリング
     *
     * @param string $title タイトル
     * @param string $message メッセージ
     * @param AlertType $type アラートの種類
     * @param boolean $visibleCloseButton 閉じるボタンを表示するかどうか
     * @return void
     */
    public static function render(string $title, string $message, AlertType $type, bool $visibleCloseButton = true): void {
        $baseColor = match($type) {
            AlertType::ERROR => 'red',
            AlertType::SUCCESS => 'green',
            AlertType::INFO => 'blue',
            AlertType::WARNING => 'yellow',
        };
        $icon = match($type) {
            AlertType::ERROR => '<i class="fa-solid fa-circle-exclamation"></i>',
            AlertType::SUCCESS => '<i class="fa-solid fa-circle-check"></i>',
            AlertType::INFO => '<i class="fa-solid fa-circle-info"></i>',
            AlertType::WARNING => '<i class="fa-solid fa-triangle-exclamation"></i>',
        };

        $padding = $visibleCloseButton ? 'pl-4 pr-10' : 'px-4';

        ?>
            <div class="alert bg-<?=$baseColor ?>-100 border border-<?=$baseColor ?>-400 text-<?=$baseColor ?>-700 py-3 rounded relative <?=$padding ?>" role="alert">
                <strong class="font-bold"><?=$icon ?> <?=convertSpecialCharsToHtmlEntities($title)?></strong>
                <span class="block sm:inline"><?=convertSpecialCharsToHtmlEntities($message)?></span>
                <?php if ($visibleCloseButton): ?>
                    <button type="button" class="alert-button absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-<?=$baseColor ?>-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </button>
                <?php endif; ?>
            </div>
            <?php if ($visibleCloseButton): ?>
                <script>
                    document.querySelectorAll('.alert-button').forEach((element) => {
                        element.addEventListener('click', (event) => {
                            element.parentElement.remove();
                        });
                    });
                </script>
            <?php endif; ?>
        <?php
    }
}
