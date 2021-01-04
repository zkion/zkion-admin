<?php

namespace App\Models\Goods;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsSpecItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'goods_spec_id',
        'goods_id',
        'key',
        'sid',
        'tid',
        'image',
    ];
}
