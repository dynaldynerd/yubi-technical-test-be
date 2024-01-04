<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class ColorMethodSalesStyle extends Model
{
    use HasFactory;
    protected $table = 'color_method_sales_styles';

    protected $fillable = [
        'sales_style_id',
        'color_method_id',
    ];

    public function sales_style(): HasMany
    {
        return $this->hasMany(SalesStyle::class, 'sales_style_id');
    }
    public function color_method(): HasMany
    {
        return $this->hasMany(ColorMethod::class, 'color_method_id');
    }
}
