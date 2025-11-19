<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Menu;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';


    protected $fillable = [
        'user_id',
        'menu_id',
        'quantity'
    ];
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}