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
        'category_id',
        'image_path',
        'condition_id',
        'price',
        'user_id',
    ];

    public function users()
    {
        return $this->$this->belongsTo(User::Class);
    }

    public function comments()
    {
        return $this->$this->hasMany(Comment::Class);
    }

    public function conditions()
    {
        return $this->$this->hasMany(Condition::Class);
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

}
