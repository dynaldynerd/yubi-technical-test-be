<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ColorNameSalesStyle extends Model
{
    use HasFactory;
    protected $table = 'color_name_sales_styles';

    protected $fillable = [
        'colormethod_sales_id',
        'color_name_id',
        'qty',
    ];

    public function colormethod_sales(): BelongsTo
    {
        return $this->belongsTo(ColorMethodSalesStyle::class, 'colormethod_sales_id');
    }

    public function color_name(): BelongsTo
    {
        return $this->belongsTo(ColorNameMethod::class, 'color_name_id');
    }
}
