<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    protected $casts = [
        'images' => 'array',
    ];

    public function getThumbnailAttribute(){
        if($this->images){
            return Storage::url(json_decode($this->images)[0]);
        }
        return asset('images/default.png');
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }
}
