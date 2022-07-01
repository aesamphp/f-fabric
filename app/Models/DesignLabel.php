<?php

namespace App\Models;

use DB;

class DesignLabel extends AppModel
{

    const TYPE_SIMPLE = 1;
    const TYPE_COLLECTION = 2;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'design_labels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['design_id', 'type_id', 'title'];

    /**
     * Set model validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'design_id' => 'required|integer',
            'type_id' => 'required|integer',
            'title' => 'required|max:255'
        ];
    }

    /**
     * Returns the label type title.
     *
     * @return string
     */
    public function getTypeTitle()
    {
        $title = null;
        if ($this->type_id === static::TYPE_SIMPLE) {
            $title = 'Simple';
        } elseif ($this->type_id === static::TYPE_COLLECTION) {
            $title = 'Collection';
        }
        return $title;
    }

    /**
     * Returns the popular labels.
     *
     * @param int $limit
     * @param int $offset
     *
     * @return type
     */
    public static function getPopularLabels($limit = 28, $offset = 0)
    {
        $designLabels = static::join('designs', 'design_labels.design_id', '=', 'designs.id')
            ->select(DB::raw('design_labels.title, COUNT(design_labels.title) as labels_count'))
            ->where('designs.private', 0)
            ->where('designs.approved', 1)
            ->whereNull('designs.deleted_at')
            ->whereNull('design_labels.deleted_at')
            ->orderBy('labels_count', 'DESC')
            ->groupBy('design_labels.title')
            ->take($limit)
            ->skip($offset)
            ->get();
        return static::buildAlphabeticalArray($designLabels->toArray());
    }

    /**
     * Returns the searched popular labels.
     *
     * @param string $keyword
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public static function searchPopularLabels($keyword, $limit = 28, $offset = 0)
    {
        $designLabels = static::join('designs', 'design_labels.design_id', '=', 'designs.id')
            ->select(DB::raw('design_labels.title, COUNT(design_labels.title) as labels_count'))
            ->where('design_labels.title', 'like', $keyword)
            ->where('designs.private', 0)
            ->where('designs.approved', 1)
            ->whereNull('designs.deleted_at')
            ->whereNull('design_labels.deleted_at')
            ->orderBy('labels_count', 'DESC')
            ->groupBy('design_labels.title')
            ->take($limit)
            ->skip($offset)
            ->get();
        return static::buildAlphabeticalArray($designLabels->toArray());
    }

    /**
     * Returns the labels array in alphabetical order.
     *
     * @param array $labels
     *
     * @return array
     */
    private static function buildAlphabeticalArray(Array $labels)
    {
        $array = [];
        sort($labels);
        foreach ($labels as $label) {
            $character                       = $label['title'][0];
            $array[strtoupper($character)][] = $label['title'];
        }
        return $array;
    }
}
