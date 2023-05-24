<?php

class ActionResponse {
    private string $location;
    private bool $isError;
    private array $data;

    /**
     * アクションのレスポンスを作成
     *
     * @param string $location リダイレクト先パス
     * @param array $data $_SESSIONに格納するデータ
     * @param boolean $isError エラーかどうか
     */
    function __construct(string $location, array $data = [], bool $isError = false) {
        $this->location = $location;
        $this->data = $data;
        $this->isError = $isError;
    }

    /**
     * リダイレクト先を取得
     *
     * @return string リダイレクト先パス
     */
    public function getLocation(): string {
        return $this->location;
    }

    /**
     * $_SESSIONに格納するデータを取得
     *
     * @return array $_SESSIONに格納するデータ
     */
    public function getData(): array {
        return $this->data;
    }

    /**
     * エラーかどうかを取得
     *
     * @return boolean エラーかどうか
     */
    public function getError(): bool {
        return $this->isError;
    }
}
