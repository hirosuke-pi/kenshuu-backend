<?php

class UsersDTO {
    function __construct(
        public readonly string $id, 
        public readonly string $username, 
        public readonly string $email, 
        public readonly string $password, 
        public readonly ?string $profileImagePath, 
        public readonly ?string $createdAt,
        public readonly ?string $deletedAt)
    {}

    function getCreatedAtDateTime(): ?DateTime {
        if ($this->createdAt === null) {
            return null;
        }
        return new DateTime($this->createdAt);
    }

    function getDeletedAtDateTime(): ?DateTime {
        if ($this->deletedAt === null) {
            return null;
        }
        return new DateTime($this->deletedAt);
    }
}
