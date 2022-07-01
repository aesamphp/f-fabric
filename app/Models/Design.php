<?php

namespace App\Models;

use DB;

class Design extends AppModel
{

    const CSV_DESTINATION_PATH = 'downloads/designs';
    const ARTWORK_DESTINATION_PATH = 'uploads/artwork';
    const XML_DESTINATION_PATH = 'downloads/xml/designs';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'designs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type_id', 'title', 'description', 'additional_details', 'dpi', 'weekly_contest_id', 'swatch_purchased', 'private', 'public', 'thumbnail_size'];

    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['description', 'additional_details', 'weekly_contest_id', 'thumbnail_size'];

    /**
     * The csv head attributes of the model.
     *
     * @var array
     */
    protected $csvHeader = ['Design ID', 'Title', 'Designer', 'Type', 'DPI', 'Description', 'Additional Details', 'Weekly Contest', 'Swatch Purchased', 'Private', 'Public', 'Approved', 'Date'];

    /**
     * Set model validation rules.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'type_id' => 'required|integer',
            'title' => 'required|max:250|regex:/^[a-zA-Z0-9- ]+$/',
            'dpi' => 'required|numeric|min:150',
            'weekly_contest_id' => 'integer',
            'swatch_purchased' => 'boolean',
            'public' => 'boolean',
            'thumbnail_size' => 'integer'
        ];
        if ($this->scenario === 'update') {
            $rules['description']        = 'max:128';
            $rules['additional_details'] = 'max:128';
            if ($this->private == 0) {
                $rules['description'] = 'required|max:128';
            }
        }
        return $rules;
    }

    /**
     * Returns the csv item array.
     *
     * @return array
     */
    public function buildCSVArray()
    {
        return [
            'friendly_id' => $this->friendly_id,
            'title' => $this->title,
            'designer_name' => $this->user->getFullName(),
            'type' => $this->type->title,
            'dpi' => $this->dpi,
            'description' => $this->description,
            'additional_details' => $this->additional_details,
            'weekly_contest' => ($this->inWeeklyContest()) ? 'Yes' : 'No',
            'swatch_purchased' => ($this->hasPurchasedSwatch()) ? 'Yes' : 'No',
            'private' => ($this->isPrivate()) ? 'Yes' : 'No',
            'public' => ($this->isPublic()) ? 'Yes' : 'No',
            'approved' => ($this->isApproved()) ? 'Yes' : 'No',
            'created_at' => formatDate($this->created_at)
        ];
    }

    /**
     * Returns the xml elements array.
     *
     * @return array
     */
    public function buildXMLElementsArray()
    {
        return [
            'design' => [
                'id' => $this->friendly_id,
                'title' => $this->title,
                'designer_name' => $this->user->getFullName(),
                'type' => $this->type->title,
                'dpi' => $this->dpi,
                'description' => $this->description,
                'additional_details' => $this->additional_details,
                'weekly_contest' => ($this->inWeeklyContest()) ? 'Yes' : 'No',
                'swatch_purchased' => ($this->hasPurchasedSwatch()) ? 'Yes' : 'No',
                'private' => ($this->isPrivate()) ? 'Yes' : 'No',
                'public' => ($this->isPublic()) ? 'Yes' : 'No',
                'approved' => ($this->isApproved()) ? 'Yes' : 'No',
                'created_at' => formatDate($this->created_at)
            ]
        ];
    }

    /**
     * Get the user that belongs to design.
     *
     * @return array
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the design type that belongs to design.
     *
     * @return array
     */
    public function type()
    {
        return $this->belongsTo('App\Models\DesignType');
    }

    /**
     * Get the categories that belongs to design.
     *
     * @return array
     */
    public function categories()
    {
        return $this->hasMany('App\Models\DesignCategory');
    }

    /**
     * Get the images that belongs to design.
     *
     * @return array
     */
    public function images()
    {
        return $this->hasMany('App\Models\DesignImage');
    }

    /**
     * Get the additional images that belongs to design.
     *
     * @return array
     */
    public function additionalImages()
    {
        return $this->hasMany('App\Models\DesignAdditionalImage');
    }

    /**
     * Get the labels that belongs to design.
     *
     * @return array
     */
    public function labels()
    {
        return $this->hasMany('App\Models\DesignLabel');
    }

    /**
     * Get the colours that belongs to design.
     *
     * @return array
     */
    public function colours()
    {
        return $this->hasMany('App\Models\DesignColour');
    }

    /**
     * Get the favourites that belongs to design.
     *
     * @return array
     */
    public function favourites()
    {
        return $this->hasMany('App\Models\FavouriteDesign');
    }

    /**
     * Get the comments that belongs to design.
     *
     * @return array
     */
    public function comments()
    {
        return $this->hasMany('App\Models\DesignComment');
    }

    /**
     * Get the weekly contest that belongs to design.
     *
     * @return array
     */
    public function weeklyContest()
    {
        return $this->belongsTo('App\Models\WeeklyContest');
    }

    /**
     * Get the contest likes that belongs to design.
     *
     * @return array
     */
    public function contestLikes()
    {
        return $this->hasMany('App\Models\DesignContestLike');
    }

    /**
     * Returns the design image path.
     *
     * @param int $typeId
     *
     * @return string
     */
    public function getImagePath($typeId)
    {
        $path  = 'images/design_placeholder.jpg';
        $image = $this->images()->where('type_id', $typeId)->first();
        return ($image) ? $image->path : $path;
    }

    /**
     * Returns the design thumbnail image path.
     *
     * @return string
     */
    public function getThumbnailImagePath()
    {
        return $this->getImagePath(DesignImage::TYPE_THUMBNAIL);
    }

    /**
     * Returns the design watermark image path.
     *
     * @return string
     */
    public function getWatermarkImagePath()
    {
        return $this->getImagePath(DesignImage::TYPE_WATERMARK);
    }

    /**
     * Return the design images.
     *
     * @return array
     */
    public function getDesignImages()
    {
        return (object)[
            'actualImagePath' => $this->getImagePath(DesignImage::TYPE_ORIGINAL),
            'filePath' => $this->getImagePath(DesignImage::TYPE_DUPLICATE),
            'highResolutionImagePath' => $this->getImagePath(DesignImage::TYPE_HIGH_RESOLUTION),
            'watermarkImagePath' => $this->getImagePath(DesignImage::TYPE_WATERMARK),
            'simpleMirrorImage' => $this->getImagePath(DesignImage::TYPE_SIMPLE_MIRROR),
            'mirrorImagePath' => $this->getImagePath(DesignImage::TYPE_MIRROR),
            'basicRepeatedImagePath' => $this->getImagePath(DesignImage::TYPE_BASIC_REPEAT),
            'halfDropRepeatedImagePath' => $this->getImagePath(DesignImage::TYPE_HALF_DROP),
            'halfBrickRepeatedImagePath' => $this->getImagePath(DesignImage::TYPE_HALF_BRICK)
        ];
    }

    /**
     * Return the design simple labels.
     *
     * @return array
     */
    public function getLabels()
    {
        return $this->labels
            ->where('type_id', DesignLabel::TYPE_SIMPLE);
    }

    /**
     * Return the design simple labels in comma seperated string.
     *
     * @return string
     */
    public function getLabelsString($glue = ", ")
    {
        $array = [];
        foreach ($this->getLabels() as $label) {
            $array[] = $label->title;
        }
        return arrayToString($array, $glue);
    }

    /**
     * Return the design collection labels.
     *
     * @return array
     */
    public function getCollectionLabels()
    {
        return $this->labels
            ->where('type_id', DesignLabel::TYPE_COLLECTION);
    }

    /**
     * Return the design collection labels in comma seperated string.
     *
     * @return string
     */
    public function getCollectionLabelsString($glue = ", ")
    {
        $array = [];
        foreach ($this->getCollectionLabels() as $label) {
            $array[] = $label->title;
        }
        return arrayToString($array, $glue);
    }

    /**
     * Return the design colours in comma seperated string.
     *
     * @return array
     */
    public function getColoursString()
    {
        $array = [];
        foreach ($this->colours as $colour) {
            $array[] = $colour->value;
        }
        return arrayToString($array, ',');
    }

    /**
     * Returns the design favourites count.
     *
     * @return int
     */
    public function getFavouritesCount()
    {
        return $this->favourites()
            ->count();
    }

    /**
     * Returns the design contest likes count.
     *
     * @return int
     */
    public function getContestLikesCount()
    {
        return $this->contestLikes()
            ->where('weekly_contest_id', $this->weekly_contest_id)
            ->count();
    }

    /**
     * Returns the design categories id.
     *
     * @return array
     */
    public function getCategoryIds()
    {
        $ids = [];
        foreach ($this->categories as $category) {
            $ids[] = $category->category_id;
        }
        return $ids;
    }

    /**
     * Return the design categories in comma seperated string.
     *
     * @param string $glue
     *
     * @return string
     */
    public function getCategoriesString($glue = ", ")
    {
        $array = [];
        foreach ($this->categories as $category) {
            $array[] = $category->category->title;
        }
        return arrayToString($array, $glue);
    }

    /**
     * Returns the design status class.
     *
     * @return string
     */
    public function getStatusClass()
    {
        $class = 'private';
        if ($this->hasPurchasedSwatch() && !$this->isDispatchApproved() && $this->isApproved()) {
            $class = 'pending';
        } elseif ($this->hasPurchasedSwatch() && $this->isDispatchApproved() && $this->isApproved()) {
            $class = 'approved';
        } elseif ($this->hasPurchasedSwatch() && $this->isDispatchApproved() && !$this->isApproved()) {
            $class = 'not-approved';
        }
        return $class;
    }

    /**
     * Returns if design is in weekly contest or not.
     *
     * @return boolean
     */
    public function inWeeklyContest()
    {
        return ($this->weeklyContest) ? true : false;
    }

    /**
     * Returns if design is public or not.
     *
     * @return boolean
     */
    public function isPublic()
    {
        return $this->public === 1;
    }

    /**
     * Returns if design is approved or not.
     *
     * @return boolean
     */
    public function isApproved()
    {
        return $this->approved === 1;
    }

    /**
     * Returns if design has purchased swatch or not.
     *
     * @return boolean
     */
    public function hasPurchasedSwatch()
    {
        return $this->swatch_purchased === 1;
    }

    /**
     * Returns if design is private or not.
     *
     * @return boolean
     */
    public function isPrivate()
    {
        return $this->private === 1;
    }

    /**
     * Returns if design is dispatch approved or not.
     *
     * @return boolean
     */
    public function isDispatchApproved()
    {
        return $this->dispatch_approved === 1;
    }

    /**
     * Returns if the user is design owner or not.
     *
     * @param int $user_id
     *
     * @return boolean
     */
    public function isOwner($user_id)
    {
        return $this->user_id === $user_id;
    }

    /**
     * Returns if design is shoppable or not.
     *
     * @return boolean
     */
    public function isShoppable()
    {
        return $this->hasPurchasedSwatch() && $this->isPublic() && $this->isApproved() && $this->isDispatchApproved();
    }

    /**
     * Returns if design is favouriteable or not.
     *
     * @return boolean
     */
    public function isFavouriteable()
    {
        if (isCustomerUser()) {
            return !$this->isOwner(getAuthenticatedUser()->id);
        }
        return false;
    }

    /**
     * Returns if design is likeable or not.
     *
     * @return boolean
     */
    public function isLikeable()
    {
        return $this->inWeeklyContest() && $this->isFavouriteable();
    }

    /**
     * Returns if user has favourited the design or not.
     *
     * @return boolean
     */
    public function hasfavourited()
    {
        return $this->favourites()->where('user_id', getAuthenticatedUser()->id)->count() > 0;
    }

    /**
     * Returns if user has liked the design or not.
     *
     * @return boolean
     */
    public function hasLiked()
    {
        return $this->contestLikes()->where('user_id', getAuthenticatedUser()->id)->where('weekly_contest_id', $this->weekly_contest_id)->count() > 0;
    }

    /**
     * Returns if design has thumbnail size or not.
     *
     * @return boolean
     */
    public function hasThumbnailSize()
    {
        return ($this->thumbnail_size) ? true : false;
    }

    /**
     * Returns design image destination path.
     *
     * @return string
     */
    public function getImageDestinationPath()
    {
        return DesignImage::IMAGE_DESTINATION_PATH . '/' . $this->user->friendly_id . '/' . $this->friendly_id;
    }

    /**
     * Returns design additional image destination path.
     *
     * @return string
     */
    public function getAdditionalImageDestinationPath()
    {
        return $this->getImageDestinationPath() . '/additional-images';
    }

    /**
     * Returns the design download file name.
     *
     * @param string $filePath
     *
     * @return string
     */
    public function getDownloadFileName($filePath)
    {
        return $this->friendly_id . '_' . $this->user->username . '_' . $this->type->title . '_' . $this->dpi . '_' . date('dmY') . '.' . pathinfo($filePath, PATHINFO_EXTENSION);
    }

    /**
     * Returns the artwork file path.
     *
     * @param string $filePath
     *
     * @return string
     */
    public function getArtworkFilePath($filePath)
    {
        return static::ARTWORK_DESTINATION_PATH . '/' . $this->getDownloadFileName($filePath);
    }

    /**
     * Returns the designer copyright text.
     *
     * @return string
     */
    public function getDesignerCopyrightText()
    {
        return '&copy; ' . $this->user->username . ' ' . date('Y');
    }

    /**
     * Returns the design additional images.
     *
     * @return array
     */
    public function getAdditionalImages()
    {
        $array = [(object)['path' => $this->getThumbnailImagePath()]];
        foreach ($this->additionalImages as $image) {
            $array[] = $image;
        }
        return $array;
    }

    /**
     * Return the popular designs.
     *
     * @return array
     */
    public static function getPopularDesigns($limit = 4, $offset = 0)
    {
        return static::join('favourite_designs', 'designs.id', '=', 'favourite_designs.design_id')
            ->select(DB::raw('designs.*, favourite_designs.design_id, COUNT(favourite_designs.design_id) as favourite_count'))
            ->where('designs.private', 0)
            ->where('designs.approved', 1)
            ->where('designs.dispatch_approved', 1)
            ->where('designs.disabled', 0)
            ->whereNull('designs.deleted_at')
            ->whereNull('favourite_designs.deleted_at')
            ->groupBy('favourite_designs.design_id')
            ->orderBy('favourite_count', 'DESC')
            ->take($limit)
            ->skip($offset)
            ->get();
    }

    /**
     * Return the recommended designs.
     *
     * @return array
     */
    public static function getRecommendedDesigns($limit = 4, $offset = 0)
    {
        return static::getPopularDesigns($limit, $offset);
    }

    /**
     * Return the latest designs.
     *
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public static function getLatestDesigns($limit = 4, $offset = 0)
    {
        return static::where('private', 0)
            ->where('approved', 1)
            ->where('dispatch_approved', 1)
            ->where('disabled', 0)
            ->orderBy('created_at', 'DESC')
            ->take($limit)
            ->skip($offset)
            ->get();
    }

    /**
     * Returns the search designs.
     *
     * @param string $keyword
     *
     * @return array
     */
    public static function searchDesigns($keyword)
    {
        return static::join('design_labels', 'designs.id', '=', 'design_labels.design_id')
            ->join('users', 'users.id', '=', 'designs.user_id')
            ->select('designs.*')
            ->where(function ($query) use ($keyword) {
                $query->where('designs.title', 'like', $keyword)
                    ->orWhere('designs.description', 'like', $keyword)
                    ->orWhere('designs.additional_details', 'like', $keyword)
                    ->orWhere('design_labels.title', 'like', $keyword)
                    ->orWhere('users.username', 'like', $keyword);
            })
            ->where('designs.private', 0)
            ->where('designs.approved', 1)
            ->where('designs.disabled', 0)
            ->whereNull('designs.deleted_at')
            ->whereNull('design_labels.deleted_at')
            ->distinct()
            ->get();
    }

    /**
     * Returns the top seller designs.
     *
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public static function getTopSellerDesigns($limit = 4, $offset = 0)
    {
        return static::join('order_items', 'designs.id', '=', 'order_items.design_id')
            ->select(DB::raw('designs.*, order_items.design_id, COUNT(order_items.design_id) as sales_count'))
            ->where('designs.private', 0)
            ->where('designs.approved', 1)
            ->where('designs.dispatch_approved', 1)
            ->where('designs.disabled', 0)
            ->whereNull('designs.deleted_at')
            ->whereNull('order_items.deleted_at')
            ->groupBy('order_items.design_id')
            ->orderBy('sales_count', 'DESC')
            ->take($limit)
            ->skip($offset)
            ->get();
    }

    /**
     * Returns the label designs.
     *
     * @param string $label
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public static function getDesignsByLabel($label, $limit = 4, $offset = 0)
    {
        return static::join('design_labels', 'designs.id', '=', 'design_labels.design_id')
            ->select('designs.*')
            ->where('design_labels.title', $label)
            ->where('designs.private', 0)
            ->where('designs.approved', 1)
            ->where('designs.dispatch_approved', 1)
            ->where('designs.disabled', 0)
            ->whereNull('designs.deleted_at')
            ->whereNull('design_labels.deleted_at')
            ->take($limit)
            ->skip($offset)
            ->distinct()
            ->get();
    }

    /**
     * Returns the related designs by designer.
     *
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public function getRelatedDesignsByDesigner($limit = 8, $offset = 0)
    {
        return static::where('id', '!=', $this->id)
            ->where('user_id', $this->user_id)
            ->where('private', 0)
            ->where('approved', 1)
            ->where('disabled', 0)
            ->take($limit)
            ->skip($offset)
            ->get();
    }

    /**
     * Returns the csv file destination path.
     *
     * @return string
     */
    public function getCSVFilePath()
    {
        return static::CSV_DESTINATION_PATH . '/designs_' . date('dmY') . '.csv';
    }

    /**
     * Returns the xml file destination path.
     *
     * @return string
     */
    public function getXMLFilePath()
    {
        return static::XML_DESTINATION_PATH . '/design_' . $this->friendly_id . '.xml';
    }

    /**
     * Returns the temporary title.
     *
     * @return string
     */
    public static function getTmpTitle()
    {
        return 'Design ' . date('d-m-Y-H-i-s');
    }

    /**
     * Function to perform default actions on events.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->user_id = getAuthenticatedUser()->id;
            $model->setIdentifier($model->title);
        });
        static::created(function ($model) {
            $setting            = Setting::where('path', 'general/artwork_id_prefix')->first();
            $prefix             = ($setting) ? $setting->value : 'AW';
            $model->friendly_id = $prefix . $model->id;
            $model->update();
        });
        static::updating(function ($model) {
            $model->setIdentifier($model->title);
        });
    }

    /**
     * @param $search
     * @return mixed
     */
    static function getDesignsBySearch($search)
    {
        return Design::where('title', 'like', $search)->get();
    }

}
