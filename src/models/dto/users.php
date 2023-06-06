<?php

class UsersDTO {
    public function __construct(
        public readonly string $id, 
        public readonly string $username, 
        public readonly string $email, 
        public readonly string $password, 
        public readonly ?string $profileImagePath, 
        public readonly ?string $createdAt,
        public readonly ?string $deletedAt)
    {}

    /**
     * ユーザーの作成日時をDateTime型で取得
     *
     * @return DateTime|null 作成日時
     */
    public function getCreatedAtDateTime(): ?DateTime {
        if (is_null($this->createdAt)) {
            return null;
        }
        return new DateTime($this->createdAt);
    }

    /**
     * ユーザーの削除日時をDateTime型で取得
     *
     * @return DateTime|null 削除日時
     */
    public function getDeletedAtDateTime(): ?DateTime {
        if (is_null($this->deletedAt)) {
            return null;
        }
        return new DateTime($this->deletedAt);
    }
}
