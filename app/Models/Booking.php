<?php

namespace App\Models;

use App\Models\service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;
    protected $fillable=[
        'time',
        'user_id',
        'price',
        'services_id'
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function services(){
        return $this->belongsTo(service::class);
    }
}
