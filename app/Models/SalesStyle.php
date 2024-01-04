<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesStyle extends Model
{
    use HasFactory;
    protected $table = 'sales_styles';
    protected $fillable = [
        'sales_order_id',
        'style_id',
        'qty'
    ];

    public function sales_order(): BelongsTo
    {
        return $this->belongsTo(SalesOrder::class, 'sales_order_id');
    }

    public function style(): BelongsTo
    {
        return $this->belongsTo(Style::class, 'style_id');
    }

    public function colorMethodSalesStyles(): HasMany
    {
        return $this->hasMany(ColorMethodSalesStyle::class, 'id');
    }
}
