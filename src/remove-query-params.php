<?php
namespace PHPQueryParams;

function remove_query_params(string | array $name, string $url): string {
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

    return build_url($parts);
}