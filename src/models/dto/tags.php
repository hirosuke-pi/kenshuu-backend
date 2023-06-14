<?php

class TagsDTO {
    function __construct(
        public readonly string $id, 
        public readonly string $tagName)
    {}
}
