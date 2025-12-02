<?php


function isActiveRoute($routeName, $output = 'active')
{
    return request()->routeIs($routeName) ? $output : '';
}


function isActiveCollapseArray($routeNames, $class = 'active'): string
{
    foreach ($routeNames as $routeName) {
        if (request()->routeIs($routeName) || request()->is($routeName)) {
            return $class;
        }
    }

    return '';
}


function formatCurrency($number, $decimal = 0)
{
    if (is_null($number)) {
        return 0;
    }

    $decimal = strlen(explode('.', (string) $number)[1] ?? '');

    return number_format($number, $decimal, '.', ' ');
}