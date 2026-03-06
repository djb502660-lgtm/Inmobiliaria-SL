<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'operation_closed',
        'title',
        'description',
        'address',
        'latitude',
        'longitude',
        'price',
        'operation',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved')
            ->where('operation_closed', false);
    }
}
