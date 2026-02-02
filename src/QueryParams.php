<?php
namespace PHPQueryParams;

class QueryParams
{
    public static function filter(array $names, string $query): string
    {
        parse_str($query, $params);
        $params = array_filter($params, fn($k): bool => in_array($k, $names), ARRAY_FILTER_USE_KEY);
        if (empty($params)) {
            throw new \Exception('Params not found in query string.');
        }
        return http_build_query($params);
    }

    public static function remove(string | array $name, string $url): string
    {
        $parts = parse_url($url);
        if (!isset($parts['query'])) {
            throw new \Exception('Query not found.');
        }
        parse_str($parts['query'], $params);

        if (is_array($name)) {
            if (empty(array_intersect($name, array_keys($params)))) {
                throw new \Exception('Any params not found.');
            }

            foreach ($name as $param) {
                if (!isset($params[$param])) {
                    continue;
                }

                unset($params[$param]);
            }
        } elseif (!isset($params[$name])) {
            throw new \Exception("Param with name - $name not found.");
        } else {
            unset($params[$name]);
        }

        if (!empty($params)) {
            $parts['query'] = http_build_query($params);
        } else {
            unset($parts['query']);
        }

        return static::toUrl($parts);
    }

    public static function set(array $values, string $url): string
    {
        $parts = parse_url($url);
        $params = [];
        if (isset($parts['query'])) {
            parse_str($parts['query'], $params);
        }

        $params = array_merge($params, $values);
        $parts['query'] = http_build_query($params);

        return static::toUrl($parts);
    }

    public static function toUrl(array $parts): string {
        $url = '';

        $delimiters = [
            'scheme'   => [
                'value' => '://',
                'after' => true
            ],
            'port'     => ['value' => ':'],
            'query'    => ['value' => '?'],
            'fragment' => ['value' => '#']
        ];

        foreach ($parts as $name => $part) {
            if (isset($delimiters[$name])) {
                if (!isset($delimiters[$name]['after'])) {
                    $url .= $delimiters[$name]['value'] . $part;
                } else {
                    $url .= $part . $delimiters[$name]['value'];
                }
            } else {
                $url .= $part;
            }
        }

        return $url;
    }
}