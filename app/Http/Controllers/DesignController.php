<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Category;
use App\Models\Design;
use App\Models\DesignAdditionalImage;
use App\Models\DesignCategory;
use App\Models\DesignColour;
use App\Models\DesignComment;
use App\Models\DesignContestLike;
use App\Models\DesignImage;
use App\Models\DesignLabel;
use App\Models\FavouriteDesign;
use App\Models\Material;
use App\Models\Product;
use App\Models\ProductMaterial;
use App\Services\ImageService;
use App\Services\XmlFileGenerator;
use File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

class DesignController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->setModel(new Design);
    }

    public function showCreateDesign()
    {
        return view('design.create')->withCategories(Category::getShoppableCategories());
    }

    public function showUploadDesign()
    {
        return view('design.upload');
    }

    public function showCategoryTabContent(Request $request, $id)
    {
        $category = Category::find($id);
        $designImagesDpi = session('designImagesDpi');

        if ($category === null) {
            return response('Category not found.', Response::HTTP_NOT_FOUND);
        }

        return view('design.' . $request->get('template'))
            ->withCategory($category)
            ->withActiveproducts($category->getActiveProducts())
            ->withDesign(Design::find($request->get('design_id')))
            ->withDesignImagesDpi($designImagesDpi)
            ->withBasket(Basket::find($request->get('basket_id')))
            ->withProductmaterials(ProductMaterial::whereProductId($category->products->first()->id)->get());
    }

    public function showProductMaterialDropdown(Request $request, $id)
    {
        $quantity = $request->get('quantity', 1);
        $currentMaterialId = (int)$request->get('current_material_id');
        $product = Product::with(['productMaterials.material.category'])->find($id);

        if ($product === null) {
            return response('Product not found.', Response::HTTP_NOT_FOUND);
        }

        $productMaterials = $product->getActiveMaterials()
            ->sortBy(function (ProductMaterial $productMaterial) {
                return !empty($productMaterial->material->category) ? (int)$productMaterial->material->category->sort : null;
            })->groupBy(function (ProductMaterial $productMaterial) {
                return !empty($productMaterial->material->category) ? $productMaterial->material->category->title : null;
            });

        if ($productMaterials->keys()->first() == '') {
            $productMaterials->put('Other', $productMaterials->shift());
        }

        $basket = Basket::find($request->get('basket_id'));

        return view('design.product-material-dropdown', compact(
            'productMaterials',
            'currentMaterialId',
            'product',
            'quantity',
            'basket'
        ));
    }

    public function showProductMaterialPrice(Request $request)
    {
        $productMaterial = ProductMaterial::find($request->get('product_material_id'));
        if ($productMaterial === null) {
            return response('Product material not found.', Response::HTTP_NOT_FOUND);
        }

        $quantity = $request->has('quantity') ? $request->get('quantity') : false;
        $hasShopPrice = $request->has('shop_price') ? true : false;

        return response(convertPriceToCurrentCurrency($productMaterial->getPriceWithQuantityRules($hasShopPrice, $quantity)));
    }

    public function showProductMaterialQuantityDiscounts(Request $request)
    {
        $productMaterial = ProductMaterial::find($request->get('product_material_id'));
        if ($productMaterial === null) {
            return response('Product material not found.', Response::HTTP_NOT_FOUND);
        }

        return view('design.quantity-discounts', [
            'productMaterial' => $productMaterial,
            'apply' => ($request->has('shop_price')) ? true : false,
        ]);
    }

    public function uploadDesign(Request $request)
    {
        $redirect = redirect()->route('view.design.upload');
        $validator = $this->validateDesign($request);
        if ($validator->fails()) {
            return $redirect->withErrors($validator)
                ->withInput();
        }
        try {
            $destinationPath = DesignImage::getImageDestinationTmpPath();
            $filePath = parent::uploadFile($request->file('file'), $destinationPath);
            $designImages = (object)array_merge($this->processDesignImages($filePath), [
                'fileOriginalName' => Design::getTmpTitle(),
                'destinationPath' => $destinationPath,
            ]);
            $resolution = (new ImageService($designImages->filePath))->getImageResolution();
            $dpiValue = $this->buildDpiValue($resolution);

            if (isCustomerUser()) {
                $design = $this->createDesign($designImages, $destinationPath, $redirect, $dpiValue);

                return redirect()->route('view.edit.design', ['id' => $design->id]);
            }
            session()->put([
                'designImages' => $designImages,
                'designImagesDpi' => $dpiValue
            ]);

            return redirect()->route('view.design.manipulate');
        } catch (\Exception $e) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function showEditDesign($id, $basketId = null)
    {
        $design = parent::getEntityByFields([
            [
                'column' => 'id',
                'condition' => '=',
                'value' => $id,
            ],
            [
                'column' => 'user_id',
                'condition' => '=',
                'value' => getAuthenticatedUser()->id,
            ],
        ]);

        return view('design.edit-design', [
            'design' => $design,
            'designImages' => $design->getDesignImages(),
            'categories' => Category::getShoppableCategories(),
            'thumbnailSizeOptions' => DesignImage::getThumbnailSizeOptions(),
            'weeklyContests' => getLiveAndUpcomingContests(),
            'products' => Product::all(),
            'materials' => Material::all(),
            'basket' => Basket::find($basketId),
        ]);
    }

    public function updateEditDesign(Request $request, $id)
    {
        $redirect = redirect()->route('view.edit.design', ['id' => $id]);
        $conditions = [
            [
                'column' => 'id',
                'condition' => '=',
                'value' => $id,
            ],
            [
                'column' => 'user_id',
                'condition' => '=',
                'value' => getAuthenticatedUser()->id,
            ],
        ];
        $entity = parent::updateEntityByFields($request->all(), $conditions, $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        $design = parent::getEntityByFields($conditions);
        $this->saveDesignCategories($request, $design);
        $this->saveDesignThumbnail($design);
        $this->saveDesignLabels($request, $design);
        $this->saveDesignColours($request, $design);
        $this->saveDesignAdditionalImages($request, $design);
        $xmlFile = new XmlFileGenerator($design->getXMLFilePath(), $design->buildXMLElementsArray());
        $xmlFile->generate();

        return $redirect->with('status', 'Design saved successfully! - <a href="' . route('view.design.upload') . '">Add another design</a>');
    }

    public function showDeleteDesign($id)
    {
        parent::deleteEntityByFields([
            [
                'column' => 'id',
                'condition' => '=',
                'value' => $id,
            ],
            [
                'column' => 'user_id',
                'condition' => '=',
                'value' => getAuthenticatedUser()->id,
            ],
        ]);

        return redirect()->route('view.user.designs')
            ->with('status', 'Design deleted successfully.');
    }

    public function uploadAdditionalImage(Request $request, $id)
    {
        try {
            $design = parent::getEntityByFields([
                [
                    'column' => 'id',
                    'condition' => '=',
                    'value' => $id,
                ],
                [
                    'column' => 'user_id',
                    'condition' => '=',
                    'value' => getAuthenticatedUser()->id,
                ],
            ]);
            $validator = parent::validateImage($request->all());
            if ($validator->fails()) {
                return response()->json($validator->errors()->getMessages(), Response::HTTP_BAD_REQUEST);
            }
            $destinationPath = $design->getAdditionalImageDestinationPath();

            return response()->json([
                'filePath' => parent::uploadFile($request->file('file'), $destinationPath),
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            abort(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function favouriteDesign($id)
    {
        $design = parent::getEntity($id);
        if ($design->isFavouriteable() && !$design->hasfavourited()) {
            $this->setModel(new FavouriteDesign);
            $redirect = redirect()->route('home');
            parent::storeEntity(['design_id' => $design->id], $redirect);

            return response($design->getFavouritesCount());
        }

        return response('Forbidden action.', Response::HTTP_FORBIDDEN);
    }

    public function unfavouriteDesign($id)
    {
        $design = parent::getEntity($id);
        $this->setModel(new FavouriteDesign);
        parent::deleteEntityByFields([
            [
                'column' => 'design_id',
                'condition' => '=',
                'value' => $design->id,
            ],
            [
                'column' => 'user_id',
                'condition' => '=',
                'value' => getAuthenticatedUser()->id,
            ],
        ]);

        return response($design->getFavouritesCount());
    }

    public function likeDesign($id)
    {
        $design = parent::getEntity($id);
        if ($design->isLikeable() && !$design->hasLiked()) {
            $this->setModel(new DesignContestLike);
            $redirect = redirect()->route('home');
            parent::storeEntity([
                'design_id' => $design->id,
                'weekly_contest_id' => $design->weekly_contest_id,
            ], $redirect);

            return response($design->getContestLikesCount());
        }

        return response('Forbidden action.', Response::HTTP_FORBIDDEN);
    }

    public function unlikeDesign($id)
    {
        $design = parent::getEntity($id);
        $this->setModel(new DesignContestLike);
        parent::deleteEntityByFields([
            [
                'column' => 'design_id',
                'condition' => '=',
                'value' => $design->id,
            ],
            [
                'column' => 'weekly_contest_id',
                'condition' => '=',
                'value' => $design->weekly_contest_id,
            ],
            [
                'column' => 'user_id',
                'condition' => '=',
                'value' => getAuthenticatedUser()->id,
            ],
        ], true);

        return response($design->getContestLikesCount());
    }

    public function storeDesignComment(Request $request, $id)
    {
        $design = parent::getEntity($id);
        $this->setModel(new DesignComment);
        $redirect = redirect()->route('view.shop.design', ['designIdentifier' => $design->identifier]);
        $request->merge(['design_id' => $design->id]);
        parent::storeEntity($request->all(), $redirect);

        return $redirect->with('status', 'Comment added successfully!');
    }

    public function processDesignImages($filePath)
    {
        $imageService = new ImageService($filePath);
        $duplicateImagePath = $imageService->makeDuplicateImage(str_replace('.' . pathinfo($filePath, PATHINFO_EXTENSION), '-duplicate.png', $filePath));
        $imageService->setImage($duplicateImagePath);
        $resolution = $imageService->getImageResolution();

        if ($resolution->x < DesignImage::DPI_DISPLAY_MIN || $resolution->y < DesignImage::DPI_DISPLAY_MIN) {
            $imageService->makeHighResolutionImage($duplicateImagePath, DesignImage::DPI_DISPLAY_MIN, DesignImage::DPI_DISPLAY_MIN);
        }
        $designImages = $this->generateDesignImages($imageService, $filePath, $duplicateImagePath);
        if ($resolution->x < DesignImage::DPI_ACTUAL_MIN || $resolution->y < DesignImage::DPI_ACTUAL_MIN) {
            $designImages['highResolutionImagePath'] = $imageService->makeHighResolutionImage(str_replace('.png', '-high-resolution.png', $duplicateImagePath));
        }

        return $designImages;
    }

    private function validateDesign($request)
    {
        return Validator::make(
            $request->all(),
            [
                'file' => 'required|max:40000|validateImage',
                'permission' => 'accepted',
            ],
            ['required' => 'The :attribute is required.']
        );
    }

    private function generateDesignImages($imageService, $filePath, $duplicateImagePath)
    {
        return [
            'actualImagePath' => $filePath,
            'filePath' => $duplicateImagePath,
            'highResolutionImagePath' => $duplicateImagePath,
            'thumbnailImagePath' => $imageService->makeThumbnailImage(str_replace('.png', '-thumbnail.png', $duplicateImagePath), 400),
            'watermarkImagePath' => $imageService->applyWatermark(str_replace('.png', '-watermark.png', $duplicateImagePath), public_path(DesignImage::WATERMARK_IMAGE_PATH)),
            'simpleMirrorImage' => $imageService->makeSimpleMirrorImage(str_replace('.png', '-mirror.png', $duplicateImagePath)),
            'mirrorImagePath' => $imageService->makeMirrorBasicRepeatedImage(str_replace('.png', '-mirror-basic-repeated.png', $duplicateImagePath)),
            'basicRepeatedImagePath' => $imageService->makeBasicRepeatedImage(str_replace('.png', '-basic-repeated.png', $duplicateImagePath)),
            'halfDropRepeatedImagePath' => $imageService->makeHalfDropRepeatedImage(str_replace('.png', '-half-drop-repeated.png', $duplicateImagePath)),
            'halfBrickRepeatedImagePath' => $imageService->makeHalfBrickRepeatedImage(str_replace('.png', '-half-brick-repeated.png', $duplicateImagePath)),
        ];
    }

    private function saveDesignCategories($request, $design)
    {
        $designCategories = ($request->has('design_category')) ? $request->input('design_category') : [];
        foreach ($designCategories as $category) {
            $data = [
                'design_id' => $design->id,
                'category_id' => $category,
            ];
            DesignCategory::firstOrCreate($data);
        }
        foreach ($design->categories as $category) {
            if (!in_array($category->category_id, $designCategories)) {
                $category->delete();
            }
        }
    }

    private function saveDesignThumbnail($design)
    {
        if ($design->hasThumbnailSize()) {
            $imageService = new ImageService($design->getImagePath(getDesignImageType('TYPE_DUPLICATE')));
            $pixels = (int)ceil($design->dpi * ($design->thumbnail_size / 2.54));
            $thumbnailImagePath = $imageService->makeDesignThumbnailImage($design->getThumbnailImagePath(), $design->getDesignImages(), $design->type->code, $pixels, 400);
            DesignImage::where([
                'design_id' => $design->id,
                'type_id' => DesignImage::TYPE_THUMBNAIL,
            ])->update(['path' => $thumbnailImagePath]);
        }
    }

    private function saveDesignLabels($request, $design)
    {
        $simpleLabels = explode(',', strtolower($request->input('labels')));
        $collectionLabels = explode(',', strtolower($request->input('collection_labels')));
        $allLabels = array_merge($simpleLabels, $collectionLabels);
        $this->saveDesignLabel($simpleLabels, $design->id, DesignLabel::TYPE_SIMPLE);
        $this->saveDesignLabel($collectionLabels, $design->id, DesignLabel::TYPE_COLLECTION);
        foreach ($design->labels as $label) {
            if (!in_array($label->title, $allLabels)) {
                $label->delete();
            }
        }
    }

    private function saveDesignLabel($requestLabels, $designId, $typeId)
    {
        foreach ($requestLabels as $label) {
            if ($label) {
                $data = [
                    'design_id' => $designId,
                    'type_id' => $typeId,
                    'title' => $label,
                ];
                DesignLabel::firstOrCreate($data);
            }
        }
    }

    private function saveDesignColours($request, $design)
    {
        $colours = explode(',', strtolower($request->input('colours')));
        foreach ($colours as $colour) {
            if ($colour) {
                $data = [
                    'design_id' => $design->id,
                    'value' => $colour,
                ];
                DesignColour::firstOrCreate($data);
            }
        }
        foreach ($design->colours as $colour) {
            if (!in_array($colour->value, $colours)) {
                $colour->delete();
            }
        }
    }

    private function saveDesignAdditionalImages($request, $design)
    {
        $additionalImages = ($request->has('additionalImages')) ? $request->input('additionalImages') : [];
        foreach ($additionalImages as $image) {
            $data = [
                'design_id' => $design->id,
                'path' => $image,
            ];
            DesignAdditionalImage::firstOrCreate($data);
        }
        foreach ($design->additionalImages as $image) {
            if (!in_array($image->path, $additionalImages)) {
                $image->delete();
            }
        }
    }

    private function createDesign($designImages, $destinationPath, $redirect, $dpi)
    {
        $data = [
            'type_id' => 1,
            'title' => $designImages->fileOriginalName,
            'dpi' => $dpi,
        ];
        $design = parent::storeEntity($data, $redirect);
        $this->moveDesignImages($designImages, $design, $destinationPath);
        $this->createDesignImages($designImages, $design, $redirect);

        return $design;
    }

    private function moveDesignImages($designImages, $design, $destinationPath)
    {
        $newDestinationPath = $design->getImageDestinationPath();
        if (!file_exists(Design::ARTWORK_DESTINATION_PATH)) {
            File::makeDirectory(Design::ARTWORK_DESTINATION_PATH);
        }
        File::copy($designImages->actualImagePath, $design->getArtworkFilePath($designImages->actualImagePath));
        File::copyDirectory($destinationPath, $newDestinationPath);
        foreach ($designImages as $key => $value) {
            $designImages->$key = str_replace($destinationPath, $newDestinationPath, $value);
        }
        //File::deleteDirectory($destinationPath);
    }

    private function createDesignImages($designImages, $design, $redirect)
    {
        $images = [
            [
                'design_id' => $design->id,
                'path' => $designImages->actualImagePath,
                'type_id' => DesignImage::TYPE_ORIGINAL,
            ],
            [
                'design_id' => $design->id,
                'path' => $designImages->filePath,
                'type_id' => DesignImage::TYPE_DUPLICATE,
            ],
            [
                'design_id' => $design->id,
                'path' => $designImages->highResolutionImagePath,
                'type_id' => DesignImage::TYPE_HIGH_RESOLUTION,
            ],
            [
                'design_id' => $design->id,
                'path' => $designImages->thumbnailImagePath,
                'type_id' => DesignImage::TYPE_THUMBNAIL,
            ],
            [
                'design_id' => $design->id,
                'path' => $designImages->watermarkImagePath,
                'type_id' => DesignImage::TYPE_WATERMARK,
            ],
            [
                'design_id' => $design->id,
                'path' => $designImages->simpleMirrorImage,
                'type_id' => DesignImage::TYPE_SIMPLE_MIRROR,
            ],
            [
                'design_id' => $design->id,
                'path' => $designImages->mirrorImagePath,
                'type_id' => DesignImage::TYPE_MIRROR,
            ],
            [
                'design_id' => $design->id,
                'path' => $designImages->basicRepeatedImagePath,
                'type_id' => DesignImage::TYPE_BASIC_REPEAT,
            ],
            [
                'design_id' => $design->id,
                'path' => $designImages->halfDropRepeatedImagePath,
                'type_id' => DesignImage::TYPE_HALF_DROP,
            ],
            [
                'design_id' => $design->id,
                'path' => $designImages->halfBrickRepeatedImagePath,
                'type_id' => DesignImage::TYPE_HALF_BRICK,
            ],
        ];
        foreach ($images as $image) {
            $this->setModel(new DesignImage);
            parent::storeEntity($image, $redirect);
        }
    }

    protected function buildDpiValue($resolution)
    {
        if ($resolution->x > DesignImage::DPI_ACTUAL_MIN || $resolution->y > DesignImage::DPI_ACTUAL_MIN) {
            return collect($resolution)->flatten()->max();
        }

        return DesignImage::DPI_ACTUAL_MIN;
    }
}
