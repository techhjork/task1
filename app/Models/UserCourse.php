<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCourse extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'class_id', 'course_id', 'grade'];
    public function course()
    {
        return $this->hasOne(Course::class, 'id', 'course_id');
    }
    public function classs()
    {
        return $this->hasOne(Classs::class, 'id', 'class_id');
    }
}
