<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'description',
        'title',
    ];

    public function createdCourses(){
    return $this->hasMany(Course::class, 'created_by');
}
    public function category(){
    return $this->belongsTo(Category::class, 'category_id');
}
    public function enrollments(){
        return $this->hasMany(Enrollment::class, 'course_id');
    }
}