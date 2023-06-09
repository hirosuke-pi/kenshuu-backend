<?php

class ActionMethod {
    /**
     * 各HTTPメソッドのクロージャーを作成
     *
     * @param string $method HTTPメソッド
     * @param Closure $action アクション
     * @param array $requireParams 必須パラメーター ['key' => 'keyType', ...]
     */
    function __construct(
        public readonly string $method,
        public readonly Closure $action,
        public readonly string $csrfPrefix,
        public readonly array $requireParams
    ) {}
}
