<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $appends = ['created_date_formatted','created_date_formatted_us'];
    protected $fillable = [
        'shipping_email',
        'shipping_notes',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_address',
        'shipping_address_2',
        'shipping_city',
        'shipping_country',
        'shipping_company',
        'shipping_state',
        'shipping_zip',
        'shipping_phone',
        'shipping_notes',
        'subtotal',
        'total',
        'billing_first_name',
        'billing_last_name',
        'billing_company',
        'billing_email',
        'billing_phone',
        'billing_country',
        'billing_state',
        'billing_city',
        'billing_zipcode',
        'billing_address',
        'order_status',
        'stripe_charge_id',
        'fedex_tracking_id',
        'coupon_code',
        'discount',
        'discount_amount',
        'tax_percent',
        'tax_amount',
        'user_id',
    ];
    protected $with = [
        'scountry',
        'sstate',
        'bcountry',
        'bstate',
    ];
    public function products(){
        return $this->hasMany(OrderProduct::class);
    }
    public function getCreatedDateFormattedAttribute(){
        return $this->created_at->diffForHumans();
    }
    public function getCreatedDateFormattedUsAttribute(){
        return date('Y-m-d h:i:s a', strtotime($this->created_at));
    }
    public function scountry(){
        return $this->belongsTo(Country::class,'shipping_country');
    }
    public function sstate(){
        return $this->belongsTo(State::class,'shipping_state');
    }
    public function bcountry(){
        return $this->belongsTo(Country::class,'billing_country');
    }
    public function bstate(){
        return $this->belongsTo(State::class,'billing_state');
    }
}
