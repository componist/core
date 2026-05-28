<?php

use Componist\Core\Facades\Component;

if (! function_exists('setting')) {
    function setting($key)
    {
        $result = Component::setting($key);
        if (isset($result[0])) {
            return $result[0];
        }

        return $result;

    }
}

if (! function_exists('menu')) {
    /**
     * get menu by name with childrens
     *
     * @return Component
     */
    function menu(string $menuName, ?string $type = null)
    {
        return Component::model('Menu')->display($menuName, $type);
    }
}

if (! function_exists('componist_route_exists')) {
    /**
     * Cached check for named route existence.
     */
    function componist_route_exists(?string $name): bool
    {
        if (! is_string($name) || $name === '') {
            return false;
        }

        static $names = null;
        if ($names === null) {
            try {
                $names = array_fill_keys(array_keys(app('router')->getRoutes()->getRoutesByName()), true);
            } catch (\Throwable $e) {
                $names = [];
            }
        }

        return isset($names[$name]);
    }
}

if (! function_exists('componist_menu_resolve_route_name')) {
    /**
     * Resolve menu item route names, including legacy aliases (e.g. logout.show).
     */
    function componist_menu_resolve_route_name(?string $name): ?string
    {
        if (! is_string($name) || $name === '') {
            return null;
        }

        /** @var array<string, string> $aliases */
        $aliases = config('componist.menu_route_aliases', [
            'logout' => 'componist.auth.logout',
            'componist.auth.logout.show' => 'componist.auth.logout',
        ]);

        $candidate = $aliases[$name] ?? $name;

        if (componist_route_exists($candidate)) {
            return $candidate;
        }

        return componist_route_exists($name) ? $name : null;
    }
}

if (! function_exists('componist_menu_requires_post')) {
    /**
     * Whether a named route must not be linked via GET (no GET/HEAD on the route).
     */
    function componist_menu_requires_post(?string $name): bool
    {
        $resolved = componist_menu_resolve_route_name($name);

        if ($resolved === null) {
            return false;
        }

        try {
            $route = app('router')->getRoutes()->getByName($resolved);
        } catch (\Throwable $e) {
            return false;
        }

        if ($route === null) {
            return false;
        }

        $methods = $route->methods();

        return ! in_array('GET', $methods, true) && ! in_array('HEAD', $methods, true);
    }
}

if (! function_exists('componist_menu_href')) {
    /**
     * Resolve a MenuItem href with minimal overhead.
     */
    function componist_menu_href($item): ?string
    {
        if (! $item) {
            return null;
        }

        $type = $item->type ?? null;
        if ($type === 'route' || $type === 'page') {
            $name = componist_menu_resolve_route_name($item->name ?? null);

            if ($name !== null) {
                return route($name);
            }

            $fallback = componist_menu_resolve_route_name($item->view_path ?? null);

            if ($fallback !== null) {
                return route($fallback);
            }

            return null;
        }

        $url = $item->name ?? null;
        return is_string($url) && $url !== '' ? url($url) : null;
    }
}

if (! function_exists('HTML_Minifier')) {
    function HTML_Minifier($string)
    {
        $string = preg_replace('/\s+/', ' ', $string);
        $string = preg_replace('/\t+/', '', $string);
        $string = preg_replace('/\r+/', '', $string);
        $string = preg_replace('/\n+/', '', $string);

        return $string;
    }
}

if (! function_exists('test')) {
    function test($text)
    {
        return $text;
    }
}
