<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'slug',
        'source',
        'desc',
        'content',
        'image',
        'active',
        'is_hot',
        'publish_date',
        'created_by',
        'like_number',
    ];

    protected $appends = [
        'categories_id'
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->BelongsToMany(Category::class, 'categories_posts');
    }

    public function getCategoriesIdAttribute(): array
    {
        return $this->categories()->pluck('id')->toArray();
    }
}
