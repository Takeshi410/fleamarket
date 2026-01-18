<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'brand',
        'description',
        'image_path',
        'condition_id',
        'price',
        'user_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::Class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::Class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::Class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function likedUsers()
    {
        return $this->belongsToMany(User::class, 'likes')
        ->withTimestamps();
    }

    public function purchasedUsers()
    {
        return $this->belongsToMany(User::class, 'purchases')
        ->withTimestamps();
    }

    public function scopeKeywordSearch($query, $keyword){
        if (!empty($keyword)) {
            $query->where('product_name', 'like', '%' . $keyword . '%');
        }
        return $query;
    }
}
