<?php

class ActionResponse {
    /**
     * アクションのレスポンスを作成
     *
     * @param string $location リダイレクト先パス
     * @param array $data $_SESSIONに格納するデータ
     * @param string $status 状態
     */
    function __construct(
        public readonly string $location,
        public readonly string $status = 'success',
        public readonly string $message = '',
        public readonly array $data = [],
    ) {}

    
}
