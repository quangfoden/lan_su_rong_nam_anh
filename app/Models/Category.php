<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'title',
        'slug',
        'desc',
        'active',
        'parent_id',
        'created_by'
    ];

    protected $appends = [
        'posts_count'
    ];

    public function parent(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public function posts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->BelongsToMany(Post::class, 'categories_posts');
    }

    public function getPostsCountAttribute(): int
    {
        return $this->posts()->active()->count();
    }
}
