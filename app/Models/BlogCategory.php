<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use SoftDeletes;
    use HasFactory;

    public const ROOT = 1;

    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'description',
    ];

    protected $appends = [
        'parent_title',
    ];

    /**
     * Батьківська категорія.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'parent_id', 'id');
    }

    /**
     * Accessor для назви батьківської категорії.
     *
     * @return string
     */
    public function getParentTitleAttribute()
    {
        return $this->parentCategory->title
            ?? ($this->isRoot() ? 'Корінь' : '???');
    }

    /**
     * Перевірка, чи категорія є кореневою.
     *
     * @return bool
     */
    public function isRoot()
    {
        return $this->id === self::ROOT;
    }
}
