<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  bussines extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'status',
        'Opining_hours',
        'user_id',
        
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
  
}
