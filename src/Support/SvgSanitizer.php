<?php

declare(strict_types=1);

namespace Componist\Core\Support;

final class SvgSanitizer
{
    public static function sanitize(?string $svg): string
    {
        $svg = (string) $svg;
        if ($svg === '') {
            return '';
        }

        $svg = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $svg) ?? $svg;
        $svg = preg_replace('/<foreignObject\b[^>]*>.*?<\/foreignObject>/is', '', $svg) ?? $svg;
        $svg = preg_replace('/\son\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $svg) ?? $svg;
        $svg = preg_replace('/javascript\s*:/i', '', $svg) ?? $svg;
        $svg = preg_replace('/<(?:iframe|object|embed|link|meta)\b[^>]*>/i', '', $svg) ?? $svg;

        return $svg;
    }
}
