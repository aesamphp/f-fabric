<?php

namespace App\Services;

use App\Services\Image\ImageMirror;
use App\Services\Image\ImageRepeat;
use App\Services\Image\ImageThumbnail;
use Image;
use ImagickException;

class ImageService
{
    use ImageThumbnail,
        ImageMirror,
        ImageRepeat;

    const PIXELS_MAX = 2000;

    private $imagePath,
        $imageHeight,
        $imageWidth;

    /**
     * Set's the image path.
     *
     * @param string $imagePath
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    /**
     * Set's the image height.
     *
     * @param int $height
     */
    public function setImageHeight($height)
    {
        $this->imageHeight = $height;
    }

    /**
     * Set's the image width.
     *
     * @param int $width
     */
    public function setImageWidth($width)
    {
        $this->imageWidth = $width;
    }

    /**
     * Set's image details.
     *
     * @param string $imagePath
     */
    public function setImage($imagePath)
    {
        $this->setImagePath($imagePath);
        $this->setImageHeight(Image::make($this->imagePath)->height());
        $this->setImageWidth(Image::make($this->imagePath)->width());
    }

    /**
     * Returns the image path.
     *
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * Returns the image height.
     *
     * @return int
     */
    public function getImageHeight()
    {
        return $this->imageHeight;
    }

    /**
     * Returns the image width.
     *
     * @return int
     */
    public function getImageWidth()
    {
        return $this->imageWidth;
    }

    /**
     * Returns the image resolution.
     *
     * @return object
     * @throws ImagickException
     */
    public function getImageResolution()
    {
        $image = new \Imagick($this->imagePath);
        return (object)$image->getimageresolution();
    }

    /**
     * Create a new image service instance.
     *
     * @param string $imagePath
     */
    public function __construct($imagePath = null)
    {
        $this->setImage($imagePath);
    }

    /**
     * @param $mirrorImagePath
     * @param int $width
     * @param int $height
     * @return mixed
     */
    public function makeMirrorBasicRepeatedImage($mirrorImagePath, $width = 0, $height = 0)
    {
        $originalImagePath = $this->getImagePath();
        $originalImageExtension = pathinfo($originalImagePath, PATHINFO_EXTENSION);
        $this->setImagePath($this->makeSimpleMirrorImage(str_replace('.' . $originalImageExtension, '-mirror.' . $originalImageExtension, $originalImagePath)));
        $mirrorBasicRepeatedImagePath = $this->makeBasicRepeatedImage($mirrorImagePath, $width, $height);
        $this->setImagePath($originalImagePath);
        return $mirrorBasicRepeatedImagePath;
    }

    /**
     * @param $highResolutionImagePath
     * @param int $x_resolution
     * @param int $y_resolution
     * @return mixed
     * @throws ImagickException
     */
    public function makeHighResolutionImage($highResolutionImagePath, $x_resolution = 300, $y_resolution = 300)
    {
        $image = new \Imagick($this->imagePath);
        $image->setImageResolution($x_resolution, $y_resolution);
        $image->writeImage($highResolutionImagePath);
        $image->destroy();
        return $highResolutionImagePath;
    }

    /**
     * @param $duplicateImagePath
     * @param int $width
     * @param int $height
     * @return mixed
     */
    public function makeDuplicateImage($duplicateImagePath, $width = 0, $height = 0)
    {
        $imageWidth = ($width === 0) ? $this->getImageWidth() : $width;
        $imageHeight = ($height === 0) ? $this->getImageHeight() : $height;
        $duplicateImage = Image::make($this->imagePath);

        if ($imageWidth > static::PIXELS_MAX) {
            $duplicateImage->resize(static::PIXELS_MAX, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        } elseif ($imageHeight > static::PIXELS_MAX) {
            $duplicateImage->resize(null, static::PIXELS_MAX, function ($constraint) {
                $constraint->aspectRatio();
            });
        } else {
            $duplicateImage->resize($imageWidth, $imageHeight);
        }

        $duplicateImage->sharpen(0)
            ->save($duplicateImagePath)
            ->destroy();

        return $duplicateImagePath;
    }

    /**
     * @param $newImagePath
     * @param $watermarkImagePath
     * @return mixed
     */
    public function applyWatermark($newImagePath, $watermarkImagePath)
    {
        $watermarkImage = Image::make($watermarkImagePath)->fit($this->getImageWidth());

        Image::make($this->imagePath)
            ->insert($watermarkImage, 'center')
            ->sharpen(0)
            ->save($newImagePath)
            ->destroy();

        $watermarkImage->destroy();

        return $newImagePath;
    }
}