<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Style extends Model
{
    use HasFactory;
    protected $table = 'styles';
    protected $fillable = [
        'style_name',
        'desc',
    ];

    public function sales_styles(): HasMany
    {
        return $this->hasMany(SalesStyle::class, 'style_id');
    }
}
