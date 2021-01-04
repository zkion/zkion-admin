<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'for',
        'for_name',
        'type',
        'filename',
        'url',
        'path',
    ];
}
