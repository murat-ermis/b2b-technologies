<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
  protected $fillable = [
    'user_id',
    'status',
    'total_price',
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
  ];

  protected $casts = [
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function items(): HasMany
  {
    return $this->hasMany(OrderItem::class);
  }

  public function products(): BelongsToMany
  {
    return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id')
      ->withPivot('quantity', 'unit_price');
  }
}
