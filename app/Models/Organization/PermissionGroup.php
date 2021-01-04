<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class PermissionGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'key',
        'guard',
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'group', 'id');
    }
}
