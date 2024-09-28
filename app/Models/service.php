<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class service extends Model
{
    use HasFactory;
    protected $fillable=[
                    'bussines_id',
                    'name',
                    'description',
                    'price'
    ];
    public function Bussines(){
        return $this->belongsTo(bussines::class,'bussines_id');
    }
}
