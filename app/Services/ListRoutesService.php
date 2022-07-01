<?php

namespace App\Services;

use Route;

class ListRoutesService
{
    /**
     * Return list of routes.
     *
     * @return array
     */
    public static function getRoutesList()
    {
        $routeCollection = Route::getRoutes();
        $pages = collect();

        $allowedPrefixes = [
            '/shop',
            '/design',
            '/blog',
            '/faqs',
            '/design-tips',
            '/community',
        ];

        foreach ($routeCollection as $route) {
            $method = current($route->getMethods());
            $prefix = $route->getPrefix();
            $path = $route->getPath();
            $name = $route->getName();
            $action = $route->getActionName();

            if (($method == 'GET')
                && (in_array($prefix, $allowedPrefixes) || $prefix == '')
                && ($name != '')
                && (strpos($path, '{') === false)
            ) {
                $pages->push([
                    'method' => $method,
                    'prefix' => $prefix,
                    'name' => ucwords(str_replace(['/', '-'], [' / ', ' '], $path)),
                    'route_url' => $path,
                    'route_name' => $name,
                    'action' => $action,
                ]);
            }
        }

        return $pages->sort();
    }

    public static function getRoutesDropdown()
    {
        $routes = self::getRoutesList();

        return array_pluck($routes, 'route_url', 'name');
    }
}
