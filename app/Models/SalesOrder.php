<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalesOrder extends Model
{
    use HasFactory;

    protected $table = 'sales_orders';
    protected $fillable = [
        'sonumber',
        'customer',
        'date'
    ];

    public function salesStyles(): HasMany
    {
        return $this->hasMany(SalesStyle::class, 'sales_order_id');
    }
}
