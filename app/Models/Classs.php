<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classs extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',

    ];

    protected $table = 'classes';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url("/admin/classes/" . $this->getKey());
    }
    public function course()
    {
        return $this->hasOne(Course::class, 'class_id', 'id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'class_id', 'id');
    }


}
