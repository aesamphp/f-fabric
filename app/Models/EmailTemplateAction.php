<?php

namespace App\Models;

class EmailTemplateAction extends AppModel {
    
    const ACTION_CONTACT_US = 1;
    const ACTION_CUSTOMER_ACCOUNT_ACTIVATION = 2;
    const ACTION_CUSTOMER_ACCOUNT_WELCOME = 3;
    const ACTION_CUSTOMER_RESET_PASSWORD = 4;
    const ACTION_ADMIN_RESET_PASSWORD = 5;
    const ACTION_NEW_ORDER_CUSTOMER_NOTIFICATION = 6;
    const ACTION_NEW_SALE_CONTRIBUTOR_NOTIFICATION = 7;
    const ACTION_NEW_ORDER_ADMIN_NOTIFICATION = 8;
    const ACTION_ORDER_CANCELLED = 9;
    const ACTION_COMMISSION_PAYMENT_SUCCESS_NOTIFICATION = 10;
    const ACTION_COMMISSION_PAYMENT_FAILED_NOTIFICATION = 11;
    const ACTION_REFUND_NOTIFICATION = 12;
    const ACTION_SHIPPING_CONFIRMATION = 13;
    const ACTION_SHIPPING_UPDATE = 14;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'email_template_actions';

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
     * Get the template that belongs to action.
     * 
     * @return array
     */
    public function template() {
        return $this->hasOne('App\Models\EmailTemplate', 'action_id');
    }

}
