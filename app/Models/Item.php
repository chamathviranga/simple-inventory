<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id', 'description', 'image', 'isActive'];

    public function category() {
         return $this->belongsTo(Category::class,'category_id');
    }

    public function stock() {
        return $this->belongsTo(Stock::class);
    }


}
