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
        $data = PageController::getRedirectData();
        if (is_null($data) || !isset($data['status']) || !isset($data['message'])) {
            return;
        }

        $title = match($data['status']) {
            'success' => '成功',
            'error' => 'エラー',
            'warning' => '警告',
            default => '',
        };

        $status = match($data['status']) {
            'success' => AlertType::SUCCESS,
            'error' => AlertType::ERROR,
            'warning' => AlertType::WARNING,
            default => AlertType::INFO,
        };

        Alert::render($title .': ', $data['message'], $status, $visibleCloseButton);
    }
}
