<?php
namespace PHPQueryParams;

function set_query_params(array $values, string $url): string {
    $parts = parse_url($url);
    $params = [];
    if (isset($parts['query'])) {
        parse_str($parts['query'], $params);
    }

    $params = array_merge($params, $values);
    $parts['query'] = http_build_query($params);

    return build_url($parts);
}