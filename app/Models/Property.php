<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'region',
        'finishing_status',
        'neighborhood',
        'address',
        'unit_type',
        'area_sqm',
        'rooms_count',
        'bathrooms_count',
        'project_name',
        'floor',
        'price_per_sqm',
        'total_price',
        'deposit',
        'unit_details',
        'client_name',
        'client_phone',
        'status',
        'required_action',
        'media',
        'unit_purpose',
        'sale_status',
        'final_sale_price',
        'created_by_id',
        'sold_by_id',
    ];

    protected $casts = [
        'media'            => 'array',
    ];

    /* المتبقي بعد خصم المقدم */
    public function getRemainingAttribute()
    {
        $total = (float)$this->total_price;
        $deposit = (float)$this->deposit;
        if ($total > 0) {
            return $total - $deposit;
        }
        return null;
    }

    public function logs()
    {
        return $this->hasMany(PropertyLog::class)->orderBy('created_at', 'desc');
    }

    public function latestLog()
    {
        return $this->hasOne(PropertyLog::class)->latestOfMany();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'sold_by_id');
    }
}
