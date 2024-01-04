<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class ColorMethod extends Model
{
    use HasFactory;
    protected $table = 'color_methods';
    protected $fillable = [
        'name',
        'desc',
    ];
    public function color_method_sales_styles(): HasMany
    {
        return $this->hasMany(ColorMethodSalesStyle::class, 'color_method_id');
    }

    public function color_name_methods(): HasMany
    {
        return $this->hasMany(ColorNameMethod::class, 'color_method_id');
    }
}
