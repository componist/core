<?php

declare(strict_types=1);

namespace Componist\Core\Support;

final class SafeHtml
{
    /**
     * @param  list<string>|null  $allowedTags
     */
    public static function sanitize(?string $html, ?array $allowedTags = null): string
    {
        $allowedTags ??= ['p', 'br', 'strong', 'em', 'b', 'i', 'u', 'ul', 'ol', 'li', 'a'];
        $allow = '';
        foreach ($allowedTags as $tag) {
            $allow .= '<'.$tag.'>';
        }

        $clean = strip_tags((string) $html, $allow);
        $clean = preg_replace('/\son\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $clean) ?? $clean;
        $clean = preg_replace('/javascript\s*:/i', '', $clean) ?? $clean;
        $clean = preg_replace('/data\s*:/i', '', $clean) ?? $clean;

        return $clean;
    }
}
