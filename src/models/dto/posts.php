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

    public function getCreatedAtDateTime(): DateTime {
        return new DateTime($this->createdAt);
    }

    public function getUpdatedAtDateTime(): ?DateTime {
        if (is_null($this->updatedAt)) {
            return null;
        }
        return new DateTime($this->updatedAt);
    }

    public function getDeletedAtDateTime(): ?DateTime {
        if (is_null($this->deletedAt === null)) {
            return null;
        }
        return new DateTime($this->deletedAt);
    }
}
