<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reviews extends Model
{
    use HasFactory;
    protected $fiilable=[
        'user_id',
        'bussines_id',
        'reviews',
        'stars',
    ];
    public function User(){
        return $this->belongsTo(User::class);
    }
    public function bussines(){
        return $this->belongsTo(bussines::class);
    }
}
