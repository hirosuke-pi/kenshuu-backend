<?php

class PostsDTO {
    public function __construct(
        public readonly string $id, 
        public readonly string $userId, 
        public readonly string $title, 
        public readonly string $body, 
        public readonly string $createdAt, 
        public readonly ?string $updatedAt, 
        public readonly ?string $deletedAt)
    {}

    /**
     * ニュースの作成日時をDateTime型で取得
     *
     * @return DateTime 作成日時
     */
    public function getCreatedAtDateTime(): DateTime {
        return new DateTime($this->createdAt);
    }

    /**
     * ニュースの更新日時をDateTime型で取得
     *
     * @return DateTime|null 更新日時
     */
    public function getUpdatedAtDateTime(): ?DateTime {
        if (is_null($this->updatedAt)) {
            return null;
        }
        return new DateTime($this->updatedAt);
    }

    /**
     * ニュースの削除日時をDateTime型で取得
     *
     * @return DateTime|null 削除日時
     */
    public function getDeletedAtDateTime(): ?DateTime {
        if (is_null($this->deletedAt === null)) {
            return null;
        }
        return new DateTime($this->deletedAt);
    }
}
