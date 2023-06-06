<?php

class ImagesDTO {
    function __construct(
        public readonly string $id, 
        public readonly string $postId,
        public readonly bool $thumbnailFlag,
        public readonly string $filePath)
    {}
}
