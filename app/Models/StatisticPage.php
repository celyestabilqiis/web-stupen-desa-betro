<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'slug', 'description', 'sort_order', 'status'])]
class StatisticPage extends Model
{
    protected function casts(): array
    {
        return ['sort_order' => 'integer', 'status' => 'boolean'];
    }

    public function categories(): HasMany
    {
        return $this->hasMany(StatisticCategory::class, 'page_id');
    }
}
