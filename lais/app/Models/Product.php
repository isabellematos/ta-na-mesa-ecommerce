<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    
    public function Tags(){
        return $this->hasMany(Tag::class);
    }

    public function Category(){
        return $this->belongsTo(Category::class);
    }

}
