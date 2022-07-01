<?php

namespace App\Models;

use Illuminate\Database\Query\Builder;

class OrderItem extends AppModel {
    
    const CSV_DESTINATION_PATH = 'downloads/orders';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['order_id', 'design_id', 'category_id', 'product_id', 'material_id', 'repeat_type', 'dpi', 'quantity', 'unit_price', 'product_weight'];
    
    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['design_id', 'material_id', 'repeat_type', 'dpi'];
    
    /**
     * The csv head attributes of the model.
     *
     * @var array
     */
    protected $csvHeader = ['Order ID', 'Category', 'Design ID', 'Design Type', 'DPI', 'Product', 'Material', 'Quantity', 'Shipping Address', 'Shipping Method', 'Status', 'Date'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'order_id' => 'required|integer',
            'design_id' => 'integer',
            'category_id' => 'required|integer',
            'product_id' => 'required|integer',
            'material_id' => 'integer',
            'dpi' => 'numeric',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric',
            'product_weight' => 'required|numeric|min:1'
        ];
    }
    
    /**
     * Returns the csv item array.
     * 
     * @return array
     */
    public function buildCSVArray() {
        return [
            'order_friendly_id' => $this->order->friendly_id,
            'category' => $this->product->category->title,
            'design_friendly_id' => ($this->isDesign()) ? $this->design->friendly_id : 'N/A',
            'design_type' => ($this->isDesign()) ? $this->getRepeatType() : 'N/A',
            'dpi' => ($this->isDesign()) ? $this->getDpi() : 'N/A',
            'product' => $this->product->title,
            'material' => ($this->isSampleBook()) ? 'N/A' : $this->material->title,
            'quantity' => $this->quantity,
            'shipping_address' => formatAddress($this->order->shippingAddress, $this->getAddressAttributes(), false),
            'shipping_method' => $this->order->shippingAddress->branding->title,
            'status' => $this->order->getStatus(),
            'created_at' => formatDate($this->created_at)
        ];
    }
    
    /**
     * Returns the order item xml elements array.
     * 
     * @return array
     */
    public function buildOrderItemXMLElementsArray() {
        return [
            'id' => ($this->isDesign()) ? $this->design->friendly_id : null,
            'sku' => $this->product->sku,
            'title' => $this->getTitle(),
            'productTitle' => $this->product->title,
            'materialTitle' => ($this->material) ? $this->material->title : null,
            'category' => $this->product->category->title,
            'productWidth' => $this->getProductWidth(),
            'productHeight' => $this->product->height,
            'repeatType' => ($this->isDesign()) ? $this->getRepeatType() : null,
            'dpi' => ($this->isDesign()) ? $this->getDpi() : null,
            'quantity' => $this->quantity,
            'weight' => $this->getWeight(),
            'machineName' => ($this->material) ? $this->material->machine_name : null,
            'profile' => ($this->material) ? $this->material->profile : null
        ];
    }
    
    /**
     * Get the order that belongs to order item.
     * 
     * @return array
     */
    public function order() {
        return $this->belongsTo('App\Models\Order');
    }
    
    /**
     * Get the design that belongs to order item.
     * 
     * @return array
     */
    public function design() {
        return $this->belongsTo('App\Models\Design');
    }
    
    /**
     * Get the category that belongs to order item.
     * 
     * @return array
     */
    public function category() {
        return $this->belongsTo('App\Models\Category');
    }
    
    /**
     * Get the product that belongs to order item.
     * 
     * @return array
     */
    public function product() {
        return $this->belongsTo('App\Models\Product');
    }
    
    /**
     * Get the material that belongs to order item.
     * 
     * @return array
     */
    public function material() {
        return $this->belongsTo('App\Models\Material');
    }
    
    /**
     * Get the repeat type that belongs to order item.
     * 
     * @return array
     */
    public function repeatType() {
        return $this->belongsTo('App\Models\DesignType', 'repeat_type');
    }
    
    /**
     * Returns order item title.
     * 
     * @return string
     */
    public function getTitle() {
        $title = $this->product->title;
        if ($this->isDesign()) {
            $title = $this->design->title;
        } elseif ($this->isColourAtlas() || $this->isPlainFabric()) {
            $title = $this->material->title . ' - ' . $this->product->title;
        }
        return $title;
    }
    
    /**
     * Returns the order item price.
     * 
     * @return float
     */
    public function getPrice() {
        return $this->unit_price * $this->quantity;
    }
    
    /**
     * Returns the order item repeat type.
     * 
     * @return float
     */
    public function getRepeatType() {
        return ($this->repeatType) ? $this->repeatType->title : $this->design->type->title;
    }
    
    /**
     * Returns the order item dpi.
     * 
     * @return float
     */
    public function getDpi() {
        return ($this->dpi) ? $this->dpi : $this->design->dpi;
    }
    
    /**
     * Checks if the order item is a colour atlas or not.
     * 
     * @return boolean
     */
    public function isColourAtlas() {
        if (empty($this->design)) {
            if ($this->product->category_id === 5) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Checks if the order item is a sample book or not.
     * 
     * @return boolean
     */
    public function isSampleBook() {
        if (empty($this->design)) {
            if ($this->product->category_id === 6) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Checks if the order item is a plain fabric or not.
     * 
     * @return boolean
     */
    public function isPlainFabric() {
        if (empty($this->design)) {
            if ($this->product->category_id === 7) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Checks if the order item is a design or not.
     * 
     * @return boolean
     */
    public function isDesign() {
        return !$this->isColourAtlas() && !$this->isSampleBook() && !$this->isPlainFabric();
    }
    
    /**
     * Returns the csv file destination path.
     * 
     * @return string
     */
    public function getCSVFilePath() {
        return static::CSV_DESTINATION_PATH . '/orders_' . date('dmY') . '.csv';
    }
    
    /**
     * Returns the order item design download file name.
     * 
     * @param string $filePath
     * 
     * @return string
     */
    public function getDownloadDesignFileName($filePath) {
        return $this->design->friendly_id . '_' . $this->design->user->username . '_' . $this->getRepeatType() . '_' . $this->getDpi() . '_' . date('dmY') . '.' . pathinfo($filePath, PATHINFO_EXTENSION);
    }
    
    /**
     * Return's the order item weight.
     * 
     * @return float
     */
    public function getWeight() {
        return $this->product_weight * $this->quantity;
    }
    
    /**
     * Return's the order item product weight.
     * 
     * @return float
     */
    public function getProductWidth() {
        $width = $this->product->width;
        if (!$this->isSampleBook()) {
            $width = ($width) ? $width : $this->material->max_width;
        }
        return $width;
    }

	/**
	 * Return's csv base query.
	 *
	 * @return Builder
	 */
    public function getCSVBaseQuery() {
    	return static::whereHas('order', function($query) {
		    $query->where('disabled', 0);
	    });
    }

}
