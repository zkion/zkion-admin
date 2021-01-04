<?php

namespace App\Models\Organization;

use App\Models\Manage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'member_counts',
        'department_id',
        'director',
        'description',
        'address',
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }

    public function manages()
    {
        return $this->belongsToMany(Manage::class);
    }
}
