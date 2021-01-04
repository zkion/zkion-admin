<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Menu extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = [
        'name',
        'icon',
        'slug',
        'permission',
        'route',
        'parent_id',
        'sort',
        'is_show',
        'description',
    ];
}
