<?php

namespace Reinholdjesse\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    use HasFactory;

    /**
     * @return HasMany<MenuItem>
     */
    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->with('children');
    }

    public function parent_title()
    {
        return $this->hasOne(MenuItem::class, 'id', 'parent_id')->value('title');
    }

    public function page()
    {
        return $this->hasOne(Page::class, 'id', 'page_id');
    }
}
