<?php

namespace App\Models;

class UserRole extends AppModel {
    
    /**
     * User role codes
     */
    const TYPE_ADMIN = 1;
    const TYPE_MANAGER = 2;
    const TYPE_MARKETING = 3;
    const TYPE_FACTORY = 4;
    const TYPE_CONTRIBUTOR = 5;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_roles';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title'];
    
    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'title' => 'required|max:255'
        ];
    }
    
    /**
     * Return's admin user roles.
     * 
     * @return array
     */
    public static function getAdminRoles() {
        return static::whereIn('id', [static::TYPE_ADMIN, static::TYPE_MANAGER, static::TYPE_MARKETING, static::TYPE_FACTORY])->get();
    }

}
