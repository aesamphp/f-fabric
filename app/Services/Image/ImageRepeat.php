<?php

namespace App\Services\Image;

use Image;

trait ImageRepeat {
    
    public function makeBasicRepeatedImage($basicRepeatedImagePath, $width = 0, $height = 0) {
        $imageWidth = ($width === 0) ? $this->getImageWidth() : $width;
        $imageHeight = ($height === 0) ? $this->getImageHeight() : $height;
        $originalImage = Image::make($this->imagePath);
        Image::canvas($this->getImageWidth() * 2, $this->getImageHeight() * 2)
                ->insert($originalImage)
                ->insert($originalImage, 'bottom-left')
                ->insert($originalImage, 'top-right')
                ->insert($originalImage, 'bottom-right')
                ->resize($imageWidth, $imageHeight)
                ->save($basicRepeatedImagePath)
                ->destroy();
        return $basicRepeatedImagePath;
    }
    
    public function makeHalfDropRepeatedImage($halfDropRepeatedImagePath, $width = 0, $height = 0) {
        $imageWidth = ($width === 0) ? $this->getImageWidth() : $width;
        $imageHeight = ($height === 0) ? $this->getImageHeight() : $height;
        $originalImage = Image::make($this->imagePath);
        Image::canvas($this->getImageWidth() * 2, $this->getImageHeight() * 2)
                ->insert($originalImage)
                ->insert($originalImage, 'bottom-left')
                ->insert($originalImage, 'top-right', 0, -1 * (int)($this->getImageHeight() / 2))
                ->insert($originalImage, 'right')
                ->insert($originalImage, 'bottom-right', 0, -1 * (int)($this->getImageHeight() / 2))
                ->resize($imageWidth, $imageHeight)
                ->save($halfDropRepeatedImagePath)
                ->destroy();
        $originalImage->destroy();
        return $halfDropRepeatedImagePath;
    }
    
    public function makeHalfBrickRepeatedImage($halfBrickRepeatedImagePath, $width = 0, $height = 0) {
        $imageWidth = ($width === 0) ? $this->getImageWidth() : $width;
        $imageHeight = ($height === 0) ? $this->getImageHeight() : $height;
        $originalImage = Image::make($this->imagePath);
        Image::canvas($this->getImageWidth() * 2, $this->getImageHeight() * 2)
                ->insert($originalImage)
                ->insert($originalImage, 'top-right')
                ->insert($originalImage, 'bottom-left', -1 * (int)($this->getImageWidth() / 2), 0)
                ->insert($originalImage, 'bottom')
                ->insert($originalImage, 'bottom-right', -1 * (int)($this->getImageWidth() / 2), 0)
                ->resize($imageWidth, $imageHeight)
                ->save($halfBrickRepeatedImagePath)
                ->destroy();
        return $halfBrickRepeatedImagePath;
    }

}
