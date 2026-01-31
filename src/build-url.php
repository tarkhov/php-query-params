<?php
namespace PHPQueryParams;

function build_url(array $parts): string {
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