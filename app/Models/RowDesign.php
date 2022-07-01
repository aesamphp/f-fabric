<?php

namespace App\Models;

class RowDesign extends AppModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'row_design';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['row_id', 'design_id'];

    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = [];

    /**
     * Set model validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'row_id' => 'required|int',
            'design_id' => 'required|int',
        ];
    }
}