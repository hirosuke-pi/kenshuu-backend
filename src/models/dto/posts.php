<?php

class PostsDTO {
    function __construct(
        public readonly string $id, 
        public readonly string $userId, 
        public readonly string $title, 
        public readonly string $body, 
        public readonly string $createdAt, 
        public readonly ?string $updatedAt, 
        public readonly ?string $deletedAt)
    {}

    function getCreatedAtDateTime(): DateTime {
        return new DateTime($this->createdAt);
    }

    function getUpdatedAtDateTime(): ?DateTime {
        if ($this->updatedAt === null) {
            return null;
        }
        return new DateTime($this->updatedAt);
    }

    function getDeletedAtDateTime(): ?DateTime {
        if ($this->deletedAt === null) {
            return null;
        }
        return new DateTime($this->deletedAt);
    }
}
