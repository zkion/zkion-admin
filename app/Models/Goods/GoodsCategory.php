<?php

namespace App\Models\Goods;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class GoodsCategory extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = [
        'name',
        'sub_name',
        'goods_model_id',
        'icon',
        'level',
        'cover',
        'sort',
        'layout_id',
        'is_recommend',
        'is_show',
        'status',
        'link',
        'keywords',
        'description',
        'last_pid',
    ];
}
