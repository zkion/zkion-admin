<?php

namespace App\Models\Goods;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsBrand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'logo',
        'description',
        'sort',
        'is_recommend',
        'status',
        'group_id',
        'category_id',
        'category_ids',
        'category_names',
        'en_name',
        'letter',
    ];
}
