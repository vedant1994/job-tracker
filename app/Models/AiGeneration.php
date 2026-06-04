<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiGeneration extends Model
{
    protected $fillable = [
        'user_id', 'job_application_id', 'type', 'result'
    ];

    public function jobApplication() {
        return $this->belongsTo(JobApplication::class);
    }
}