<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = ['title','slug', 'description','thumbnail','job_type_id'];

    protected $casts = ['thumbnail' => 'array'];

    protected $attributes = ['thumbnail' => '[]'];

    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }
    public function applicants(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
