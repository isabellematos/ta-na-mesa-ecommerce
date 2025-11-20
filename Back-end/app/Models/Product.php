<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    protected $fillable = [
        'name',
        'price',
        'units',
        'image1',
        'image2',
        'category_id',
        'description',
        'user_id', 
    ];

    public function Tags(){
        return $this->hasMany(Tag::class);
    }

    public function Category(){
        return $this->belongsTo(Category::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }
}
