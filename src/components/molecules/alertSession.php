<?php

require_once __DIR__ .'/../atoms/alert.php';

class AlertSession {
    /**
     * ステータス情報がセッション内にあった場合は、アラートをレンダリングする
     *
     * @param boolean $visibleCloseButton 閉じるボタンを表示するかどうか
     * @return void
     */
    public static function render(bool $visibleCloseButton = true): void {
        [$status, $message] = PageController::getRedirectStatus();
        if ($status === null || $message === null) {
            return;
        }

        $title = match($status) {
            'success' => '成功',
            'error' => 'エラー',
            'warning' => '警告',
            default => '',
        };
        $type = match($status) {
            'success' => AlertType::SUCCESS,
            'error' => AlertType::ERROR,
            'warning' => AlertType::WARNING,
            default => AlertType::INFO,
        };

        Alert::render($title .': ', $message, $type, $visibleCloseButton);
    }
}
