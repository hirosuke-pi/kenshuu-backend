<?php

class ImagesRepo {
    /**
     * サムネイルの画像パスを取得
     *
     * @param string $postId 投稿ID
     * @return string 画像パス
     */
    public static function getThumbnailSrcByPostId(string $postId): string {
        $db = PDOFactory::getPDOInstance();

        $imagesDao = new ImagesDAO($db);
        $imagesDto = $imagesDao->getThumbnailByPostId($postId);

        if (is_null($imagesDto)) {
            return DEFAULT_THUMBNAIL;
        } 

        return '/img/news/'. $postId .'/'. $imagesDto->filePath;
    }

    /**
     * 投稿IDを元に画像パスリストを取得
     *
     * @param string $postId 投稿ID
     * @return array 画像パスリスト
     */
    public static function getImagesSrcByPostId(string $postId): array {
        $db = PDOFactory::getPDOInstance();

        $imagesDao = new ImagesDAO($db);
        $imagesDtoList = $imagesDao->getImagesByPostId($postId);

        $imagesSrcList = [];
        foreach($imagesDtoList as $imagesDto) {
            $imagesSrcList[] = '/img/news/'. $postId .'/'. $imagesDto->filePath;
        }

        return $imagesSrcList;
    }

    /**
     * 画像データをテーブルに挿入
     *
     * @param string $postId 投稿ID
     * @param boolean $thumbnailFlag サムネイルかどうか
     * @param string $fileExt ファイル拡張子
     * @return string 画像ファイル名
     */
    public static function createImageFile(string $postId, bool $thumbnailFlag, string $fileExt): string {
        $db = PDOFactory::getPDOInstance();
        $imagesDao = new ImagesDAO($db);

        $imageId = 'image_' . uniqid(mt_rand());
        $filename = $imageId .'.'. convertSpecialCharsToHtmlEntities($fileExt);
        $imagesDao->createImage($imageId, $postId, $thumbnailFlag, $filename);

        return $filename;
    }
}
