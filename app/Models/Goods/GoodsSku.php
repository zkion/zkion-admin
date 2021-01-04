<?php

namespace App\Models\Goods;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsSku extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'marketPrice',
        'costPrice',
        'stock',
        'lower_stock',
        'goods_weight',
        'limit_buy',
        'goods_id',
        'image',
        'items',
        'key',
        'key_name',
        'status',
        'is_default_sku',
        'single',
    ];

    public function setItemsAttribute($value)
    {
        $this->attributes['items'] = json_encode($value);
    }
}
