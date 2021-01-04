<?php

namespace App\Models\Goods;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsSpec extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'goods_id',
        'is_image',
        'sid',
        'sort',
        'items',
    ];

    public function setItemsAttribute($value)
    {
        $this->attributes['items'] = json_encode($value);
    }
}
