<?php

declare(strict_types=1);

namespace Componist\Core\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait BelongsToUser
{
    public function scopeForUser(Builder $query, ?int $userId = null): Builder
    {
        $userId ??= auth()->id() !== null ? (int) auth()->id() : null;

        if ($userId === null || $userId < 1) {
            return $query->whereRaw('0 = 1');
        }

        return $query->where($query->getModel()->getTable().'.user_id', $userId);
    }

    public function resolveRouteBinding($value, $field = null): ?Model
    {
        $field ??= $this->getRouteKeyName();
        $query = $this->newQuery()->where($this->qualifyColumn($field), $value);

        if (auth()->check()) {
            $query->forUser((int) auth()->id());
        }

        return $query->first();
    }

    public function isOwnedBy(?int $userId = null): bool
    {
        $userId ??= auth()->id() !== null ? (int) auth()->id() : 0;

        return $userId > 0 && (int) $this->getAttribute('user_id') === $userId;
    }
}
