<?php

class Middleware {
    public function __construct(
        public readonly Closure $actionMiddleware,
        public readonly array $requirePropKeys = []
    ) {}

    public function run(array $props): ActionResponse {
        // キーとその型をチェック
        checkKeyTypes($props, $this->requirePropKeys);

        // クロージャを実行
        $actionResponse = $this->actionMiddleware($props);

        // 型チェック
        if (!is_a($actionResponse, ActionResponse::class)) {
            // 返り値がActionResponseでなければエラーをスロー
            throw new Exception('Return value type not match: ' . gettype($actionResponse));
        }

        return $actionResponse;
    }
    
}
