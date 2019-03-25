<?php

namespace Elephanto;

use Elephanto\Http\HttpClient;

/**
 * Elephanto class
 * @author Salomon Dion (dev.mrdion@gmail.com)
 */
class Elephanto
{
    public static function fetch(string $url, array $conf = [])
    {
        $method = $conf['method'] ?? 'GET';

        switch ($method) {
            case 'POST':
                return static::post($url, $conf);
            default:
                return static::get($url, $conf);
        }
    }

    public static function get(string $url, array $conf = [])
    {
        $http = new HttpClient;
        return $http->get($url, $conf);
    }

    public static function post(string $url, $data = null, array $conf = [])
    {
        $http = new HttpClient;
        return $http->post($url, $data, $conf);
    }

    public static function create(array $options = [])
    {
        return new HttpClient($options);
    }
}
