<?php

namespace App\Models;

use DB;
use Carbon\Carbon;
use App\Services\BucksNetService;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Models\UserRole;
use App\Models\Studio;
use App\Models\Design;
use App\Models\Order;
use App\Models\FavouriteDesign;
use App\Models\UserAddress;
use App\Models\Sale;
use App\Models\PaymentDetail;

class User extends AppModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable,
        Authorizable,
        CanResetPassword;

    const CSV_DESTINATION_PATH = 'downloads/users';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'username',
        'password',
        'group_id',
        'role_id',
        'facebook_id',
        'sales_email',
        'favourites_email',
        'newsletter_email',
        'subscribed_at',
    ];

    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = [
        'friendly_id',
        'facebook_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The csv head attributes of the model.
     *
     * @var array
     */
    protected $csvHeader = [
        'User ID',
        'Name',
        'Username',
        'Email Address',
        'VAT Registered',
        'VAT Number',
        'Date',
        'Live for sale',
        'Waiting for approval',
        'Not for sale',
        'Total Commission',
        'Commission earned in last 90 days',
        'Commission outstanding / unpaid (number)',
        'Commission outstanding / unpaid (value)',
        'Total purchases made (value)',
        'Total purchases made by quantity',
        'Average order (value)',
        'Total purchases made in last 90 days',
        'Last purchase made',
        'Total discounts used',
    ];

    /**
     * Set model validation rules.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        if ($this->scenario === 'insert' || $this->scenario === 'insert-admin' || $this->scenario === 'update') {
            $rules['first_name'] = 'required|max:255';
            $rules['last_name'] = 'required|max:255';
            $rules['email'] = 'required|email|max:255|unique:users,email,' . $this->id;
            $rules['username'] = [
                'required',
                'max:255',
                'regex:/^[a-zA-Z0-9.\-_]+$/',
                'unique:users,username,' . $this->id
            ];
        }
        if ($this->scenario === 'insert' || $this->scenario === 'insert-admin' || $this->scenario === 'update-password') {
            $rules['password'] = 'required|confirmed|min:8';
        }
        if ($this->scenario === 'insert' || $this->scenario === 'insert-admin') {
            $rules['group_id'] = 'required|integer';
            $rules['role_id'] = 'required|integer';
        }
        if ($this->scenario === 'insert') {
            $rules['terms'] = 'accepted';
        }
        $rules['facebook_id'] = 'numeric';
        $rules['sales_email'] = 'boolean';
        $rules['favourites_email'] = 'boolean';
        $rules['newsletter_email'] = 'boolean';
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
            'name' => $this->getFullName(),
            'username' => $this->username,
            'email' => $this->email,
            'vat_registered' => $this->isVATRegistered() ? 'Yes' : 'No',
            'vat_number' => $this->isVATRegistered() ? $this->getVATNumber() : 'N/A',
            'created_at' => formatDate($this->created_at),
            'live_for_sale' => $this->getUserLiveForSaleDesignsCount() ?: 'N/A',
            'waiting_for_approval' => $this->getUserWaitingApprovalDesignsCount() ?: 'N/A',
            'not_for_sale' => $this->getNotForSaleDesignsCount() ?: 'N/A',
            'total_commission' => $this->getTotalCommissions() ?: 'N/A',
            'commission_last_90_days' => $this->getCommissionsForNinetyDays() ?: 'N/A',
            'unpaid_commission' => $this->getUnpaidCommissionsCount() ?: 'N/A',
            'unpaid_commission_value' => $this->getUnpaidCommissionsValue() ?: 'N/A',
            'total_value' => $this->getAllOrdersSum() ?: 'N/A',
            'total_purchases_made_by_quantity' => $this->getTotalPurchasesByQuantitySum() ?: 'N/A',
            'order_average' => $this->formatOrderAverage() ?: 'N/A',
            'order_value_last_90_days' => $this->getOrdersNinetyDays() ?: 'N/A',
            'latest_order' => $this->formatLatestOrder() ?: 'N/A',
            'total_discounts' => $this->getTotalDiscountsCount() ?: 'N/A',
        ];
    }

    /**
     * Set model validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'terms.required' => 'You must accept the Terms of Use.'
        ];
    }

    /**
     * Get the role that belongs to user.
     *
     * @return array
     */
    public function role()
    {
        return $this->belongsTo(UserRole::class);
    }

    /**
     * Get the studio that belongs to user.
     *
     * @return array
     */
    public function studio()
    {
        return $this->hasOne(Studio::class);
    }

    /**
     * Get the designs that belongs to user.
     *
     * @return array
     */
    public function designs()
    {
        return $this->hasMany(Design::class);
    }

    /**
     * Get the orders that belongs to user.
     *
     * @return array
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the favourites that belongs to user.
     *
     * @return array
     */
    public function favourites()
    {
        return $this->hasMany(FavouriteDesign::class);
    }

    /**
     * Get the addresses that belongs to user.
     *
     * @return array
     */
    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    /**
     * Get the sales that belongs to user.
     *
     * @return array
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Get the payment detail that belongs to user.
     *
     * @return array
     */
    public function paymentDetail()
    {
        return $this->hasOne(PaymentDetail::class);
    }

    /**
     * Checks the provided user role with the existing one.
     *
     * @param int $role
     *
     * @return boolean
     */
    public function hasRole($role)
    {
        return $this->role_id === $role;
    }

    /**
     * Checks the provided user group with the existing one.
     *
     * @param int $group
     *
     * @return boolean
     */
    public function hasGroup($group)
    {
        return $this->group_id === $group;
    }

    /**
     * Returns the user's full name.
     *
     * @return string
     */
    public function getFullName()
    {
        return formatName([$this->first_name, $this->last_name]);
    }

    /**
     * Returns if user has a default address or not.
     *
     * @return boolean
     */
    public function hasDefaultAddress()
    {
        return $this->addresses()->count() > 0;
    }

    /**
     * Returns user default address.
     *
     * @return \App\Models\UserAddress
     */
    public function getDefaultAddress()
    {
        return $this->addresses()
            ->first();
    }

    /**
     * Returns if user has payment details or not.
     *
     * @return boolean
     */
    public function hasPaymentDetails()
    {
        return ($this->paymentDetail) ? true : false;
    }

    /**
     * Returns if user has bucksnet payment details.
     *
     * @return boolean
     */
    public function hasBucksnetPaymentDetails()
    {
        return $this->hasPaymentDetails() && $this->paymentDetail->country === "GB";
    }

    /**
     * Returns if user is VAT registered.
     *
     * @return boolean
     */
    public function isVATRegistered()
    {
        return $this->hasPaymentDetails() && $this->paymentDetail->vat_registered === 1;
    }

    /**
     * Returns user's vat number.
     *
     * @return string
     */
    public function getVATNumber()
    {
        return ($this->isVATRegistered()) ? $this->paymentDetail->vat_number : null;
    }

    /**
     * Returns the bucksnet payemtn details.
     *
     * @return array
     */
    public function getBucksnetDetails()
    {
        $paymentDetails = [
            'bank_name' => null,
            'account_holder_name' => null,
            'account_number' => null,
            'sort_code' => null
        ];
        if ($this->hasBucksnetPaymentDetails()) {
            $bucksnet = new BucksNetService;
            $bucksnet->MakeRequest(BucksNetService::ACTION_ACCOUNT_RETRIEVE_DETAILS, [
                'AccountReference' => $this->paymentDetail->bucksnet_id
            ]);
            if (!$bucksnet->fails()) {
                $bankDetails = $bucksnet->getResponse()->AccountRetrieveDetailsResult;
                $paymentDetails['bank_name'] = $this->paymentDetail->bank_name;
                $paymentDetails['account_holder_name'] = $bankDetails->AccountName;
                $paymentDetails['account_number'] = $bankDetails->AccountNo;
                $paymentDetails['sort_code'] = str_replace('-', '', $bankDetails->SortCode);
            }
        }
        return (object)$paymentDetails;
    }

    /**
     * Return the active designs.
     *
     * @param int $limit
     *
     * @return array
     */
    public function getActiveDesigns($limit = null)
    {
        $query = $this->designs()
            ->whereDisabled(false)
            ->latest();
        return ($limit) ? $query->paginate($limit) : $query->get();
    }

    /**
     * Return the active category designs.
     *
     * @param int $categoryId
     * @param int $limit
     *
     * @return array
     */
    public function getCategoryDesigns($categoryId, $limit = null)
    {
        $query = $this->designs()
            ->join('design_categories', 'designs.id', '=', 'design_categories.design_id')
            ->select('designs.*')
            ->where('designs.public', 1)
            ->where('designs.approved', 1)
            ->where('designs.private', 0)
            ->where('designs.disabled', 0)
            ->where('design_categories.category_id', $categoryId)
            ->whereNull('design_categories.deleted_at')
            ->orderBy('designs.created_at', 'DESC');
        return ($limit) ? $query->paginate($limit) : $query->get();
    }

    /**
     * Return the not for sale designs.
     *
     * @param int $limit
     *
     * @return array
     */
    public function getNotForSaleDesigns($limit = null)
    {
        $query = $this->designs()
            ->wherePrivate(false)
            ->whereApproved(true)
            ->wherePublic(false)
            ->whereDisabled(false)
            ->latest();
        return ($limit) ? $query->paginate($limit) : $query->get();
    }

    /**
     * Return the latest designs.
     *
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public function getLatestDesigns($limit = 4, $offset = 0)
    {
        return $this->designs()
            ->where('disabled', 0)
            ->latest()
            ->take($limit)
            ->skip($offset)
            ->get();
    }

    /**
     * Get images for the widget builder
     *
     * @param $limit
     * @param $designs
     * @param $order
     * @return mixed
     */
    public function getImagesForWidgetBuilder($limit, $designs, $order)
    {
        if ($designs == "my_shop") {
            return $this->designs()
                ->where('disabled', 0)
                ->where('deleted_at', null)
                ->orderBy($order == "random" ? DB::raw('RAND()') : 'created_at', 'DESC')
                ->take($limit)
                ->get();
        }

        return $this->favourites()
            ->where('deleted_at', 0)
            ->orderBy($order == "random" ? DB::raw('RAND()') : 'created_at', 'DESC')
            ->take($limit)
            ->get();
    }

    /**
     * Return the favourite designs.
     *
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public function getFavouriteDesigns($limit = 4, $offset = 0)
    {
        return $this->favourites()
            ->latest()
            ->take($limit)
            ->skip($offset)
            ->get();
    }

    /**
     * Return the waiting for approval designs.
     *
     */
    public function getUserWaitingApprovalDesignsCount()
    {
        return $this->designs()
            ->wherePrivate(true)
            ->count();
    }

    /**
     * Return the live for sale designs.
     *
     */
    public function getUserLiveForSaleDesignsCount()
    {
        return $this->designs()
            ->wherePrivate(true)
            ->count();
    }

    /**
     * Returns the total commission
     *
     * @return float
     */
    public function getTotalCommissions()
    {
        return $this->sales()->sum('amount');
    }

    /**
     * Returns the total commission for 3 months
     *
     * @return float
     */
    public function getCommissionsForNinetyDays()
    {
        return $this->sales()
            ->where('created_at', '>', Carbon::now()->subDays(90))
            ->sum('amount');
    }

    /**
     * Return the recent orders.
     *
     * @return array
     */
    public function getRecentOrders($limit = 3, $offset = 0)
    {
        return $this->orders()
            ->where('disabled', 0)
            ->latest()
            ->take($limit)
            ->skip($offset)
            ->get();
    }

    /**
     * Return the latest order.
     *
     * @return array
     */
    public function getLatestOrder()
    {
        return $this->orders()
            ->whereDisabled(false)
            ->latest()
            ->take(1)
            ->pluck('created_at');
    }

    /**
     * Format the latest order created_at.
     *
     * @return array
     */
    public function formatLatestOrder()
    {
        if ($this->getLatestOrder()) {
            return formatDate($this->getLatestOrder());
        }
    }

    /**
     * Return the orders.
     *
     * @return array
     */
    public function getAllOrders()
    {
        return $this->orders()
            ->whereDisabled(false)
            ->latest()
            ->get();
    }

    /**
     * Return the orders count value.
     *
     * @return array
     */
    public function getAllOrdersSum()
    {
        return $this->orders()
            ->whereDisabled(false)
            ->sum('amount');
    }

    /**
     * Return the orders quantity total value.
     *
     * @return int
     */
    public function getTotalPurchasesByQuantitySum()
    {
        return $this->orders()
            ->whereDisabled(false)
            ->get()
            ->flatMap(function($item) {
                return $item->orderItems->pluck('quantity');
            })
            ->sum();
    }

    /**
     * Return total discounts.
     *
     * @return array
     */
    public function getTotalDiscountsCount()
    {
        return $this->orders()
            ->has('discountCodeUsed')
            ->count();
    }

    /**
     * Return the orders count value.
     *
     * @return array
     */
    public function getOrdersAverage()
    {
        return $this->orders()
            ->where('disabled', 0)
            ->avg('amount');
    }

     /**
     * Format the average order value.
     *
     * @return array
     */
    public function formatOrderAverage()
    {
        if ($this->getLatestOrder()) {
            return number_format($this->getOrdersAverage(), 2);
        }
    }

    /**
     * Return orders for 3 months.
     *
     * @return array
     */
    public function getOrdersNinetyDays()
    {
        return $this->orders()
            ->where('created_at', '>', Carbon::now()->subDays(90))
            ->whereDisabled(false)
            ->sum('amount');
    }

    /**
     * Return the search designs.
     *
     * @param string $keyword
     * @param int $limit
     *
     * @return array
     */
    public function getSearchDesigns($keyword, $limit = null)
    {
        $keyword = '%' . $keyword . '%';
        $query = $this->designs()
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', $keyword)
                    ->orWhere('description', 'like', $keyword)
                    ->orWhere('additional_details', 'like', $keyword);
            })
            ->where('disabled', 0)
            ->latest();
        return ($limit) ? $query->paginate($limit) : $query->get();
    }

    /**
     * Returns the all designs count.
     *
     * @param boolean $private
     *
     * @return int
     */
    public function getAllDesignsCount($private = true)
    {
        $query = $this->designs()
            ->where('disabled', 0);
        if ($private === false) {
            $query->where('private', 0);
        }
        return $query->count();
    }

    /**
     * Returns the category designs count.
     *
     * @param int $categoryId
     *
     * @return int
     */
    public function getCategoryDesignsCount($categoryId)
    {
        return $this->designs()
            ->join('design_categories', 'designs.id', '=', 'design_categories.design_id')
            ->select('designs.*')
            ->where('designs.public', 1)
            ->where('designs.approved', 1)
            ->where('designs.private', 0)
            ->where('designs.disabled', 0)
            ->where('design_categories.category_id', $categoryId)
            ->whereNull('design_categories.deleted_at')
            ->count();
    }

    /**
     * Returns the not for sale designs count.
     *
     * @return int
     */
    public function getNotForSaleDesignsCount()
    {
        return $this->designs()
            ->where('private', 0)
            ->where('approved', 1)
            ->where('public', 0)
            ->where('disabled', 0)
            ->count();
    }

    /**
     * Returns user sales count.
     *
     * @return int
     */
    public function getSalesCount()
    {
        return $this->sales()
            ->wherePaid(1)
            ->count();
    }

    /**
     * Returns user upaid sales count.
     *
     * @return int
     */
    public function getUnpaidCommissionsCount()
    {   
        return $this->sales()
            ->wherePaid(false)
            ->count();
    }

    /**
     * Returns user unpaid sales sum.
     *
     * @return int
     */
    public function getUnpaidCommissionsValue()
    {
        return $this->sales()
            ->wherePaid(false)
            ->sum('amount');
    }

    /**
     * Returns user sales total.
     *
     * @return float
     */
    public function getSalesTotal()
    {
        return $this->sales()
            ->wherePaid(true)
            ->max('amount');
    }

    /**
     * Returns the order customer xml elements array.
     *
     * @return array
     */
    public function buildOrderCustomerXMLElementsArray()
    {
        return ['name' => $this->getFullName(), 'username' => $this->username, 'email' => $this->email];
    }

    /**
     * Returns the csv file destination path.
     *
     * @return string
     */
    public function getCSVFilePath()
    {
        return static::CSV_DESTINATION_PATH . '/users_' . date('dmY') . '.csv';
    }

    /**
     * Function to perform default actions on events.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->password = bcrypt($model->password);
        });
        static::created(function ($model) {
            $setting = Setting::where('path', 'general/user_id_prefix')->first();
            $prefix = ($setting) ? $setting->value : 'X';
            $model->friendly_id = $prefix . $model->id;
            $model->update();
        });
    }
}
