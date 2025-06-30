<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Enrollment;

class Evaluation extends Model
{
    use SoftDeletes;
    /** @use HasFactory<\Database\Factories\EvaluationFactory> */
    use HasFactory;

    protected $fillable = [
    'enrollment_id', 
    'score', 
    'feedback',
    'evaluated_at'
];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
