<?php

class ActionResponse {
    /**
     * アクションのレスポンスを作成
     *
     * @param string $location リダイレクト先パス
     * @param array $data $_SESSIONに格納するデータ
     * @param boolean $isError エラーかどうか
     */
    function __construct(
        public readonly string $location,
        public readonly array $data = [],
        public readonly bool $isError = false
    ) {}
}
