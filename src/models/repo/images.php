<?php

class ImagesRepo {
    public static function getThumbnailSrcByPostId(string $postId): string {
        $db = PDOFactory::getNewPDOInstance();

        $imagesDao = new ImagesDAO($db);
        $imagesDto = $imagesDao->getThumbnailByPostId($postId);

        if (is_null($imagesDto)) {
            return DEFAULT_THUMBNAIL;
        } 

        return '/img/news/'. $postId .'/'. $imagesDto->filePath;
    }

    public static function getImagesSrcByPostId(string $postId): array {
        $db = PDOFactory::getNewPDOInstance();

        $imagesDao = new ImagesDAO($db);
        $imagesDtoList = $imagesDao->getImagesByPostId($postId);

        $imagesSrcList = [];
        foreach($imagesDtoList as $imagesDto) {
            $imagesSrcList[] = '/img/news/'. $postId .'/'. $imagesDto->filePath;
        }

        return $imagesSrcList;
    }
}
