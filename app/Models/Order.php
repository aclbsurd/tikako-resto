<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDetail; 

class Order extends Model
{
    use HasFactory;


    protected $table = 'orders';


    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'nomor_meja'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}