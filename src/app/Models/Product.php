<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;


class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'image', 'description'];

    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'product_season');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
