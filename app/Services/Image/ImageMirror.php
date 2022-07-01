<?php

namespace App\Services\Image;

use Image;

trait ImageMirror {
    
    public function makeFlipHorizontalImage($flipHorizontalImagePath, $width = 0, $height = 0) {
        $imageWidth = ($width === 0) ? $this->getImageWidth() : $width;
        $imageHeight = ($height === 0) ? $this->getImageHeight() : $height;
        Image::make($this->imagePath)
                ->flip('h')
                ->resize($imageWidth, $imageHeight)
                ->save($flipHorizontalImagePath)
                ->destroy();
        return $flipHorizontalImagePath;
    }
    
    public function makeFlipVerticalImage($flipVerticalImagePath, $width = 0, $height = 0) {
        $imageWidth = ($width === 0) ? $this->getImageWidth() : $width;
        $imageHeight = ($height === 0) ? $this->getImageHeight() : $height;
        Image::make($this->imagePath)
                ->flip('v')
                ->resize($imageWidth, $imageHeight)
                ->save($flipVerticalImagePath)
                ->destroy();
        return $flipVerticalImagePath;
    }
    
    public function makeSimpleMirrorImage($mirrorImagePath, $width = 0, $height = 0) {
        $flipHorizontalImagePath = $flipVerticalImagePath = null;
        $imageWidth = ($width === 0) ? $this->getImageWidth() : $width;
        $imageHeight = ($height === 0) ? $this->getImageHeight() : $height;
        $mirrorImageExtension = pathinfo($mirrorImagePath, PATHINFO_EXTENSION);
        if (str_contains($mirrorImagePath, 'mirror')) {
            $flipHorizontalImagePath = str_replace('mirror', 'flip-horizontal', $mirrorImagePath);
            $flipVerticalImagePath = str_replace('mirror', 'flip-vertical', $mirrorImagePath);
        } else {
            $flipHorizontalImagePath = str_replace('.' . $mirrorImageExtension, '-flip-horizontal.' . $mirrorImageExtension, $mirrorImagePath);
            $flipVerticalImagePath = str_replace('.' . $mirrorImageExtension, '-flip-vertical.' . $mirrorImageExtension, $mirrorImagePath);
        }
        $this->makeFlipHorizontalImage($flipHorizontalImagePath);
        $this->makeFlipVerticalImage($flipVerticalImagePath);
        return $this->makeMirrorImage($mirrorImagePath, $flipHorizontalImagePath, $flipVerticalImagePath, $imageWidth, $imageHeight);
    }
    
    protected function makeMirrorImage($mirrorImagePath, $flipHorizontalImagePath, $flipVerticalImagePath, $imageWidth, $imageHeight) {
        $originalImage = Image::make($this->imagePath);
        $flipHorizontalImage = Image::make($flipHorizontalImagePath);
        $flipVerticalImage = Image::make($flipVerticalImagePath);
        Image::canvas($this->getImageWidth() * 2, $this->getImageHeight() * 2)
                ->insert($flipVerticalImage)
                ->insert($flipVerticalImage->flip('h'), 'top-right')
                ->insert($originalImage, 'bottom-left')
                ->insert($flipHorizontalImage, 'bottom-right')
                ->resize($imageWidth, $imageHeight)
                ->save($mirrorImagePath)
                ->destroy();
        $originalImage->destroy();
        $flipHorizontalImage->destroy();
        $flipVerticalImage->destroy();
        return $mirrorImagePath;
    }

}
