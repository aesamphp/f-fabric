<?php

namespace App\Services\Image;

use App\Models\DesignType;
use Image;

trait ImageThumbnail {
    
    public function makeThumbnailImage($thumbnailImagePath, $size = 200) {
        Image::make($this->imagePath)
                ->fit($size)
                ->save($thumbnailImagePath)
                ->destroy();
        return $thumbnailImagePath;
    }
    
    public function makeDesignThumbnailImage($thumbnailImagePath, $designImages, $thumbnailRepeatType, $thumbnailSize = 200, $imageSize = 200) {
        $this->applyDesignThumbnailImageRules($designImages, $thumbnailRepeatType, $thumbnailSize)
                ->resize($imageSize, $imageSize)
                ->save($thumbnailImagePath)
                ->destroy();
        return $thumbnailImagePath;
    }
    
    protected function applyDesignThumbnailImageRules($designImages, $repeatType, $thumbnailSize) {
        $image = Image::make($this->imagePath);
        $imageWidth = $this->getImageWidth();
        $imageHeight = $this->getImageHeight();
        $thumbnailImage = Image::canvas($thumbnailSize, $thumbnailSize);
        if ($repeatType === DesignType::TYPE_CENTER) {
            $thumbnailImage->insert($image, 'center');
        } else {
            if ($repeatType === DesignType::TYPE_HALF_DROP) {
                $image = Image::make($designImages->halfDropRepeatedImagePath)->resize($imageWidth * 2, $imageHeight * 2);
            } elseif ($repeatType === DesignType::TYPE_HALF_BRICK) {
                $image = Image::make($designImages->halfBrickRepeatedImagePath)->resize($imageWidth * 2, $imageHeight * 2);
            } elseif ($repeatType === DesignType::TYPE_MIRROR) {
                $image = Image::make($designImages->simpleMirrorImage)->resize($imageWidth * 2, $imageHeight * 2);
            }
            $imageWidth = ($repeatType === DesignType::TYPE_BASIC) ? $imageWidth : $image->width();
            $imageHeight = ($repeatType === DesignType::TYPE_BASIC) ? $imageHeight : $image->height();
            $thumbnailImage = $this->insertDesignThumbnailImage($image, $thumbnailImage, $thumbnailSize, $imageWidth, $imageHeight);
        }
        $image->destroy();
        return $thumbnailImage;
    }
    
    protected function insertDesignThumbnailImage($image, $thumbnailImage, $thumbnailSize, $imageWidth, $imageHeight) {
        if ($imageWidth < $thumbnailSize && $imageHeight < $thumbnailSize) {
            $thumbnailImage = $this->insertDesignThumbnailImageMatrix($image, $thumbnailImage, $thumbnailSize, $imageWidth, $imageHeight);
        } elseif ($imageWidth < $thumbnailSize) {
            $thumbnailImage = $this->insertDesignThumbnailImageHorizontal($image, $thumbnailImage, $thumbnailSize, $imageWidth);
        } elseif ($imageHeight < $thumbnailSize) {
            $thumbnailImage = $this->insertDesignThumbnailImageVertical($image, $thumbnailImage, $thumbnailSize, $imageHeight);
        } else {
            $thumbnailImage->insert($image);
        }
        return $thumbnailImage;
    }
    
    protected function insertDesignThumbnailImageMatrix($image, $thumbnailImage, $thumbnailSize, $imageWidth, $imageHeight) {
        for ($w = 0; $w <= $thumbnailSize; $w += $imageWidth) {
            for ($h = 0; $h <= $thumbnailSize; $h += $imageHeight) {
                $thumbnailImage->insert($image, 'top-left', $w, $h);
            }
        }
        return $thumbnailImage;
    }
    
    protected function insertDesignThumbnailImageHorizontal($image, $thumbnailImage, $thumbnailSize, $imageWidth) {
        for ($i = 0; $i <= $thumbnailSize; $i += $imageWidth) {
            $thumbnailImage->insert($image, 'top-left', $i, 0);
        }
        return $thumbnailImage;
    }
    
    protected function insertDesignThumbnailImageVertical($image, $thumbnailImage, $thumbnailSize, $imageHeight) {
        for ($i = 0; $i <= $thumbnailSize; $i += $imageHeight) {
            $thumbnailImage->insert($image, 'top-left', 0, $i);
        }
        return $thumbnailImage;
    }

}
