<?php


if (!function_exists('url_join')) {
    /**
     * @param string $url
     * @param string|int|null $params
     * @return string
     */
    function url_join(string $url, string|int $params = null): string
    {
        if ($params) {
            return $url . '/' . $params;
        }
        return $url;
    }
}
