<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserClass extends Model
{
    use HasFactory;
    protected $table = 'user_classes';
    protected $fillable = ['user_id', 'class_id'];

    public function classes()
    {
        return $this->hasOne(Classs::class, 'id', 'class_id');
    }

}
