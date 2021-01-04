<?php

namespace App\Models\Goods;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subtitle',
        'sn',
        'sku_id',
        'goods_type',
        'spec_type',
        'pay_type',
        'thumb',
        'brand_id',
        'category_id',
        'category_ids',
        'category_names',
        'region_id',
        'region_ids',
        'keywords',
        'description',
        'is_free_shipping',
        'status',
        'tags',
        'goods_content',
        'sort',
        'seller_id',
        'store_id',
        'physical_store_id',
        'suppliers_id',
        'join_activity',
        'sale_counts',
        'view_counts',
        'comment_counts',
        'collect_counts',
    ];

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }

    public function specs()
    {
        return $this->hasMany(GoodsSpec::class);
    }

    public function category()
    {
        return $this->belongsTo(GoodsCategory::class);
    }

    public function sku()
    {
        return $this->hasOne(GoodsSku::class, 'id', 'sku_id');
    }
}
