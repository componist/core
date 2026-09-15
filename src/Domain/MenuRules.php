<?php

declare(strict_types=1);

namespace Componist\Core\Domain;

final class MenuRules
{
    public const PROTECTED_NAME = 'admin';

    /**
     * @return array<string, mixed>
     */
    public static function rules(): array
    {
        return [
            'name' => 'required|string|min:3',
        ];
    }

    public static function canDelete(string $name): bool
    {
        return strtolower(trim($name)) !== self::PROTECTED_NAME;
    }
}
