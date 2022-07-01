<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carousel;
use App\Models\CarouselSlide;

class CarouselController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->setModel(new Carousel);
    }

    public function showCarousels(Request $request) {
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $carousels = parent::getEntities($offset);
        if ($request->ajax()) {
            return view('admin::carousel.carousel-row', ['carousels' => $carousels]);
        }
        return view('admin::carousel.carousels', [
            'carousels' => $carousels,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }

    public function showCarousel(Request $request, $id) {
        return view('admin::carousel.carousel', ['carousel' => parent::getEntity($id)]);
    }

    public function updateCarousel(Request $request, $id) {
        $redirect = redirect()->route('admin::view.carousel', ['id' => $id]);
        parent::updateEntity($request->all(), $id, $redirect);
        return $redirect->with('status', 'Carousel updated!');
    }
    
    public function newSlide(Request $request, $id) {
        return view('admin::carousel.new-slide', [
            'ctaTypes' => CarouselSlide::getCTATypeOptions(),
            'carousel' => parent::getEntity($id)
        ]);
    }
    
    public function storeSlide(Request $request, $id) {
        $carousel = parent::getEntity($id);
        $this->setModel(new CarouselSlide);
        $redirect = redirect()->route('admin::new.carousel.slide', ['id' => $carousel->id]);
        if ($request->hasFile('file')) {
            $validator = parent::validateImage($request->all());
            if ($validator->fails()) {
                return $redirect->withErrors($validator)
                        ->withInput();
            }
            $filePath = parent::uploadFile($request->file('file'), CarouselSlide::IMAGE_DESTINATION_PATH);
            $request->merge(['image_path' => $filePath]);
        }
        $entity = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        return redirect()->route('admin::view.carousel', ['id' => $id])
                ->with('status', 'Carousel slide added!');
    }
    
    public function showSlide(Request $request, $id, $slideId) {
        $carousel = parent::getEntity($id);
        $this->setModel(new CarouselSlide);
        $slide = parent::getEntity($slideId);
        return view('admin::carousel.slide', [
            'ctaTypes' => CarouselSlide::getCTATypeOptions(),
            'carousel' => $carousel,
            'slide' => $slide
        ]);
    }
    
    public function updateSlide(Request $request, $id, $slideId) {
        $this->setModel(new CarouselSlide);
        $slide = parent::getEntity($slideId);
        $redirect = redirect()->route('admin::view.carousel.slide', ['id' => $id, 'slideId' => $slideId]);
        if ($request->hasFile('file')) {
            $validator = parent::validateImage($request->all());
            if ($validator->fails()) {
                return $redirect->withErrors($validator)
                        ->withInput();
            }
            $filePath = parent::uploadFile($request->file('file'), CarouselSlide::IMAGE_DESTINATION_PATH);
            $request->merge(['image_path' => $filePath]);
        }
        parent::updateEntity($request->all(), $slide->id, $redirect);
        return $redirect->with('status', 'Carousel slide updated!');
    }
    
    public function deleteSlide(Request $request, $id, $slideId) {
        $this->setModel(new CarouselSlide);
        parent::deleteEntity($slideId);
        return redirect()->route('admin::view.carousel', ['id' => $id])
                ->with('status', 'Carousel slide deleted!');
    }

}
