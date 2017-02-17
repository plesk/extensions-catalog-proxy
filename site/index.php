<?php

$data = json_decode(file_get_contents('https://ext.plesk.com' . $_SERVER['PATH_INFO']));

$data = array_filter($data, function($item) {
    // filter everything sold via go.plesk.com, except docker and wp-toolkit
    if (0 === strpos($item->buy_url, 'https://go.plesk.com') && !in_array($item->code, ['docker', 'wp-toolkit'])) {
        return null;
    }

    return $item;
});

header('Content-Type: application/json');
echo json_encode(array_values($data));
