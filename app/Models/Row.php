<?php

namespace App\Models;

class Row extends AppModel
{
    const DISABLE = 0;
    const ENABLE = 1;

    const ROW_TYPE_DEFAULT = 1;
    const ROW_TYPE_LABEL = 2;
    const ROW_TYPE_DESIGNER = 3;
    const ROW_TYPE_DESIGN = 4;

    const DEFAULT_ROW_TYPE_POPULAR_PRODUCTS = 1;
    const DEFAULT_ROW_TYPE_OUR_TOP_SELLERS = 2;
    const DEFAULT_ROW_TYPE_RECENTLY_ADDED = 3;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rows';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'status', 'type', 'data'];

    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['data'];

    /**
     * Set model validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:250',
            'status' => 'required|boolean',
            'type' => 'required|int'
        ];
    }

    /**
     * Returns the CTA type options.
     *
     * @return array
     */
    public static function getRowTypeOptions()
    {
        return [
            ['id' => static::ROW_TYPE_DEFAULT, 'title' => 'Default'],
            ['id' => static::ROW_TYPE_LABEL, 'title' => 'Label'],
            ['id' => static::ROW_TYPE_DESIGNER, 'title' => 'Designer'],
            ['id' => static::ROW_TYPE_DESIGN, 'title' => 'Design']
        ];
    }

    /**
     * @return array
     */
    public static function getStatusOptions()
    {
        return [
            ['id' => static::DISABLE, 'title' => 'Disable'],
            ['id' => static::ENABLE, 'title' => 'Enable']
        ];
    }

    /**
     * @return array
     */
    public static function getDefaultRowOptions()
    {
        return [
            ['id' => static::DEFAULT_ROW_TYPE_POPULAR_PRODUCTS, 'title' => 'Popular Products'],
            ['id' => static::DEFAULT_ROW_TYPE_OUR_TOP_SELLERS, 'title' => 'Our Top Sellers'],
            ['id' => static::DEFAULT_ROW_TYPE_RECENTLY_ADDED, 'title' => 'Recently Added']
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function designs()
    {
        return $this->belongsToMany(Design::class, 'row_design');
    }

    public function label()
    {
        return DesignLabel::whereId($this->data)->first();
    }

    public function getDesignsByLabel()
    {
        return Design::getDesignsByLabel($this->label()->title);
    }

    public function studio()
    {
        return Studio::whereId($this->data)->first();
    }

    public function getStudioDesigns()
    {
        return User::whereId($this->studio()->user_id)->first()->getLatestDesigns();
    }

    public static function getRows()
    {
        return Row::whereStatus(1)->whereNull('deleted_at')->get()->map(function (Row $row) {

            if ($row->type == Row::ROW_TYPE_DEFAULT) {
                if ($row->data == Row::DEFAULT_ROW_TYPE_POPULAR_PRODUCTS) {
                    $row->header  = "Popular Products";
                    $row->href    = route('view.shop.all', ['filter' => 'most-popular']);
                    $row->designs = Design::getPopularDesigns();
                    return $row;
                }
                if ($row->data == Row::DEFAULT_ROW_TYPE_OUR_TOP_SELLERS) {
                    $row->header  = "OUR TOP SELLERS";
                    $row->href    = route('view.shop.all', ['filter' => 'best-seller']);
                    $row->designs = Design::getTopSellerDesigns();
                    return $row;
                }
                if ($row->data == Row::DEFAULT_ROW_TYPE_RECENTLY_ADDED) {
                    $row->header  = "RECENTLY ADDED";
                    $row->href    = route('view.shop.all', ['filter' => 'new']);
                    $row->designs = Design::getLatestDesigns();
                    return $row;
                }
            }

            if ($row->type == Row::ROW_TYPE_LABEL && $row->label()) {
                $row->header  = "'" . $row->label()->title . "' PRODUCTS";
                $row->href    = route('view.shop.all', ['labels[]' => $row->label()->title]);
                $row->designs = $row->getDesignsByLabel();
                return $row;
            }

            if ($row->type == Row::ROW_TYPE_DESIGNER && $row->studio()) {
                $row->header  = $row->studio()->username . "'s LATEST PRODUCTS";
                $row->href    = route('view.designer.store', ['username' => $row->studio()->username]);
                $row->designs = $row->getStudioDesigns();
                return $row;
            }

            if ($row->type == Row::ROW_TYPE_DESIGN && $row->designs()) {
                $row->header  = "FEATURED PRODUCTS";
                $row->href    = route('view.shop.all');
                $row->designs = $row->designs()->get();

                return $row;
            }
        });

    }

}