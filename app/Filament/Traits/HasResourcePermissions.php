<?php

namespace App\Filament\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasResourcePermissions
{
    protected static function getPermissionPrefix(): string
    {
        return strtolower(class_basename(static::$model));
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view ' . static::getPermissionPrefix());
    }

    public static function canView(Model $record): bool
    {
        return auth()->user()?->can('view ' . static::getPermissionPrefix());
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create ' . static::getPermissionPrefix());
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('edit ' . static::getPermissionPrefix());
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->can('delete ' . static::getPermissionPrefix());
    }
}
