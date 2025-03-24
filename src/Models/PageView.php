<?php

namespace WdevRs\LaravelAnalytics\Models;

use Database\Factories\PageViewFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PageView extends Model
{
    use HasFactory;

    protected $table;

    protected $guarded = ['id']; // Prevent mass assignment for ID

    protected $fillable = [
        'session_id',
        'path',
        'user_agent',
        'ip',
        'referer',
        'county',
        'city',
        'page_model_type',
        'page_model_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function newFactory(): Factory
    {
        return PageViewFactory::new();
    }

    /**
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->table = config('laravel-analytics.db_prefix') . 'page_views';

        parent::__construct($attributes);
    }

    /**
     * Get the related page model.
     *
     * @return MorphTo
     */
    public function pageModel(): MorphTo
    {
        return $this->morphTo();
    }
}
