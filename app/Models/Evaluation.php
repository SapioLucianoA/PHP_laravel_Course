<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable =[
        'score',
        'feedback',
        'evaluated_at '
    ];
    public function enrollment(){
        return $this->belongsTo(Enrollment::class, 'enrollment_id');
    }

}
