<?php

namespace App\Http\Controllers\Checkout;

use App\Models\Basket;
use App\Models\Design;
use App\Models\DesignImage;
use File;

trait HandleDesign {
    
    protected function createDesign() {
        $redirect = redirect()->route('view.basket');
        $basket = Basket::getBasketItems();
        $newBasket = [];
        foreach ($basket as $item) {
            if (Basket::isDesign($item)) {
                $item = $this->handleCreateDesign($item, $redirect);
            } else {
                $item->design_id = null;
            }
            $newBasket[] = $item;
        }
        session()->put('basket', $newBasket);
    }
    
    protected function handleCreateDesign($item, $redirect) {
        $this->setModel(new Design);
        if (!Basket::isSavedDesign($item)) {
            $data = [
                'type_id' => $item->design_type_id,
                'title' => $item->design_images->fileOriginalName,
                'dpi' => $item->dpi,
                'swatch_purchased' => 1,
            ];
            $design = parent::storeEntity($data, $redirect);
            $item->design_saved = 1;
            $item->design_id = $design->id;
            $this->moveDesignImages($item, $design);
            $this->createDesignImages($item, $redirect);
        } else {
            $design = parent::getEntity($item->design_id);
            if ($design->isOwner(getAuthenticatedUser()->id)) {
                $design->swatch_purchased = 1;
                if (Basket::hasRequestedPublic($item)) {
                    $design->private = 0;
                    $design->public = 1;
                }
                $design->update();
            }
        }
        return $item;
    }
    
    protected function moveDesignImages($item, $design) {
        $destinationPath = $item->design_images->destinationPath;
        $newDestinationPath = $design->getImageDestinationPath();
        if (!file_exists(Design::ARTWORK_DESTINATION_PATH)) {
            File::makeDirectory(Design::ARTWORK_DESTINATION_PATH);
        }
        File::copy($item->design_images->actualImagePath, $design->getArtworkFilePath($item->design_images->actualImagePath));
        File::copyDirectory($destinationPath, $newDestinationPath);
        foreach ($item->design_images as $key => $value) {
            $item->design_images->$key = str_replace($destinationPath, $newDestinationPath, $value);
        }
        //File::deleteDirectory($destinationPath);
    }
    
    protected function createDesignImages($item, $redirect) {
        $designImages = [
            ['design_id' => $item->design_id, 'path' => $item->design_images->actualImagePath, 'type_id' => DesignImage::TYPE_ORIGINAL],
            ['design_id' => $item->design_id, 'path' => $item->design_images->filePath, 'type_id' => DesignImage::TYPE_DUPLICATE],
            ['design_id' => $item->design_id, 'path' => $item->design_images->highResolutionImagePath, 'type_id' => DesignImage::TYPE_HIGH_RESOLUTION],
            ['design_id' => $item->design_id, 'path' => $item->design_images->thumbnailImagePath, 'type_id' => DesignImage::TYPE_THUMBNAIL],
            ['design_id' => $item->design_id, 'path' => $item->design_images->watermarkImagePath, 'type_id' => DesignImage::TYPE_WATERMARK],
            ['design_id' => $item->design_id, 'path' => $item->design_images->simpleMirrorImage, 'type_id' => DesignImage::TYPE_SIMPLE_MIRROR],
            ['design_id' => $item->design_id, 'path' => $item->design_images->mirrorImagePath, 'type_id' => DesignImage::TYPE_MIRROR],
            ['design_id' => $item->design_id, 'path' => $item->design_images->basicRepeatedImagePath, 'type_id' => DesignImage::TYPE_BASIC_REPEAT],
            ['design_id' => $item->design_id, 'path' => $item->design_images->halfDropRepeatedImagePath, 'type_id' => DesignImage::TYPE_HALF_DROP],
            ['design_id' => $item->design_id, 'path' => $item->design_images->halfBrickRepeatedImagePath, 'type_id' => DesignImage::TYPE_HALF_BRICK]
        ];
        foreach ($designImages as $image) {
            $this->setModel(new DesignImage);
            parent::storeEntity($image, $redirect);
        }
    }

}
