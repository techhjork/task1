<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'class_id',
        'name',
        'strength',
        'level',
        'tutor',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/courses/' . $this->getKey());
    }
    public function classs()
    {
        return $this->hasOne(classs::class, 'id', 'class_id');
    }
    public function usercourse()
    {
        return $this->hasOne(UserCourse::class, 'course_id', 'id');

    }
}
