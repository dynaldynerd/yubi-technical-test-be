<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ColorNameMethod extends Model
{
    use HasFactory;
    protected $table = 'color_name_methods';
    protected $fillable = [
        'name',
        'color_method_id'
    ];
    public function color_method(): BelongsTo
    {
        return $this->belongsTo(ColorMethod::class, 'color_method_id');
    }

    public function color_name_sales_styles(): HasMany
    {
        return $this->hasMany(ColorNameSalesStyle::class, 'color_name_id');
    }
}
