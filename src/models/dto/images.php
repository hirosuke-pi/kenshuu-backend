<?php

class ImagesDTO {
    function __construct(
        public readonly string $id, 
        public readonly string $postId,
        public readonly bool $thumbnailFlag,
        public readonly string $filePath,
        public readonly string $deletedAt)
    {}

    /**
     * 画像削除日時をDateTime型で取得
     *
     * @return DateTime 作成日時
     */
    public function getCreatedAtDateTime(): DateTime {
        return new DateTime($this->deletedAt);
    }
}
