<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_id',
        'rider_id',
        'total_price',
        'address',
        'note',
        'status',
        'delivered_at',
        'delivery_image',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'delivered_at' => 'datetime',
        'status' => OrderStatus::class,
    ];

    /**
     * Get the items in this order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the user who owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the store who owns the order.
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the rider who delivers the order.
     */
    public function rider()
    {
        return $this->belongsTo(Rider::class);
    }
}
