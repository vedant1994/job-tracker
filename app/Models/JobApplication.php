<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = [
        'user_id','company_name','job_title','job_url',
        'job_description','status','applied_date',
        'deadline','salary_range','notes'
    ];

    protected $casts = [
        'applied_date' => 'date',
        'deadline'     => 'date',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function aiGenerations() {
        return $this->hasMany(AiGeneration::class);
    }
}