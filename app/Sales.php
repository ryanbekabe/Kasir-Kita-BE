<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use App\Setting;
use Carbon\Carbon;

class Sales extends Model
{
    use SoftDeletes;

    protected $appends = [
                            'total_formatted',
                            'subtotal_formatted',
                            'total_discount_formatted',
                            'change_formatted',
                            'tax_formatted',
                            'amount_formatted',
                            'created_at_formatted'
                    ];
    protected $fillable = ['number'];
    public function details()
    {
        return $this->hasMany('App\SalesDetail');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getTotalFormattedAttribute()
    {
        return $this->formattedValue($this->total);
    }

    public function getSubTotalFormattedAttribute()
    {
        return $this->formattedValue($this->subtotal);
    }

    public function getTotalDiscountFormattedAttribute()
    {
        return $this->formattedValue($this->total_discount);
    }

    public function getChangeFormattedAttribute()
    {
        return $this->formattedValue($this->change);
    }

    public function getTaxFormattedAttribute()
    {
        return $this->formattedValue($this->tax);
    }

    public function getAmountFormattedAttribute()
    {
        return $this->formattedValue($this->amount);
    }

    protected function formattedValue($value)
    {
        $setting = Setting::first();
        if (is_numeric($value) && floor($value) != $value) {
            return $setting->currency.number_format($value, 2, !empty($setting->decimal_separator) ? $setting->decimal_separator : '' , !empty($setting->thousand_separator) ? $setting->thousand_separator : '');
        } else {
            return $setting->currency.number_format($value, 0, !empty($setting->decimal_separator) ? $setting->decimal_separator : '' , !empty($setting->thousand_separator) ? $setting->thousand_separator : '');
        }
    }

    public function getCreatedAtFormattedAttribute()
    {
        return Carbon::parse($this->created_at)->format('m/d/Y');
    }
}
