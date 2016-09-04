<?php

namespace ContactsGrabber;

use Closure;
use GuzzleHttp\Client;

class Utils
{
    /**
     * @param $url
     * @param string $method
     * @param array $options
     * @return string
     * @throws \Exception
     */
    public static function makeRequest($url, $method = 'GET', $options = [])
    {
        $client = new Client([
            'timeout' => 5,
        ]);

        $response = $client->request($method, $url, $options);

        if ($response->getStatusCode() != 200) {
            throw new \Exception('Request failed');
        }

        return (string)$response->getBody();
    }

    /**
     * Utils::makeRequest and json_decode(reponse)
     *
     * @param $url
     * @param string $method
     * @param array $options
     * @return mixed
     */
    public static function makeJsonRequest($url, $method = 'GET', $options = [])
    {
        $response = Utils::makeRequest($url, $method, $options);
        $data = json_decode($response, true);

        return $data;
    }

    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     *
     * @link https://github.com/rappasoft/laravel-helpers/blob/master/src/helpers.php
     */
    public static function getFromArray($array, $key, $default = null)
    {
        if (is_null($key)) {
            return $array;
        };

        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment)
        {
            if ( ! is_array($array) || ! array_key_exists($segment, $array))
            {
                return $default instanceof Closure ? $default() : $default;
            }

            $array = $array[$segment];
        }

        return $array;
    }
}