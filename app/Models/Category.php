<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'id',
        'name',
        'decription',
    ];
    public function course(){
        return $this->hasMany(Course::class, 'category_id');
    }
}
