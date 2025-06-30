<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\course;

class Category extends Model
{
    use SoftDeletes;
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
        protected $fillable = [
        'name',
        'description',
    ];
    protected $hidden = [
    'created_at',
    'updated_at',
    'deleted_at',
];
    public function courses()
    {
        return $this->hasMany(course::class, 'category_id');
    }
}
