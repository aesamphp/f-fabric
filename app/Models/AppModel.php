<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppModel extends Model {

    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    
    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = [];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    /**
     * The scenario of the model.
     *
     * @var string
     */
    protected $scenario = 'insert';
    
    /**
     * The attributes that should converted into string.
     *
     * @var array
     */
    protected $toString = [];
    
    /**
     * The attributes of an address.
     *
     * @var array 
     */
    protected $addressAttributes = ['getFullName', 'address_line1', 'address_line2', 'city', 'postcode', 'state', 'getCountryName', 'phone'];
    
    /**
     * The lazy eager loading attributes of the model.
     *
     * @var array
     */
    protected $load = [];
    
    /**
     * The csv head attributes of the model.
     *
     * @var array
     */
    protected $csvHeader = [];
    
    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [];
    }
    
    /**
     * Set model validation messages.
     * 
     * @return array
     */
    public function messages() {
        return [];
    }
    
    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function downloadCSVRules() {
        return [
            'from_date' => 'required|date',
            'to_date' => 'required|date|after:from_date'
        ];
    }
    
    /**
     * Returns the csv item array.
     * 
     * @return array
     */
    public function buildCSVArray() {
        return [];
    }
    
    /**
     * Function to perform default actions on events.
     */
    protected static function boot() {
        parent::boot();
        static::creating(function($model) {
            $model->setNullableFields();
        });
        static::updating(function($model) {
            $model->setNullableFields();
        });
    }
    
    /**
     * Sets the model scenario.
     * 
     * @param string $scenario
     */
    public function setScenario($scenario) {
        $this->scenario = $scenario;
    }
    
    /**
     * Returns the model address attributes.
     * 
     * @return array
     */
    public function getAddressAttributes() {
        return $this->addressAttributes;
    }
    
    /**
     * Returns the model csv attributes.
     * 
     * @return array
     */
    public function getCSVHeader() {
        return $this->csvHeader;
    }
    
    /**
     * Sets the nullable attributes to null be default.
     */
    protected function setNullableFields() {
        foreach ($this->nullable as $field) {
            if ($this->$field === "") {
                $this->$field = null;
            }
        }
    }
    
    /**
     * Sets the identifier using the provided string.
     * 
     * @param string $string
     * @param int $num
     */
    public function setIdentifier($string, $num = null) {
        $this->identifier = str_slug($string);
        if ($num) {
            $this->identifier = $this->identifier . '-' . $num;
            $num++;
        } else {
            $num = 2;
        }
        $entity = $this->where('identifier', $this->identifier)->first();
        if (!empty($entity)) {
            if ($entity->id !== $this->id) {
                $this->setIdentifier($string, $num);
            }
        }
    }
    
    /**
     * Returns the model data into string.
     * 
     * @param string $glue
     * 
     * @return string
     */
    public function toString($glue = ", ") {
        $array = [];
        foreach ($this->toString as $attribute) {
            if ($this->$attribute) {
                $array[$attribute] = $this->$attribute;
            }
        }
        return arrayToString((empty($array)) ? $this->toArray() : $array, $glue);
    }
    
    /**
     * Returns the model object to array with lazy eager loaded relations.
     * 
     * @return array
     */
    public function loadToArray() {
        return $this->load($this->load)->toArray();
    }

}
