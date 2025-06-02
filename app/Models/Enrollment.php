<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'course_id',
        'user_id',
        'enrolled_at '
    ];
    
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function evaluations(){
        return $this->hasMany(Evaluation::class, 'enrollment_id');
    }
}
