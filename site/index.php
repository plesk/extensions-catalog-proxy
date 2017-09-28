<?php

$whiteList = ['docker', 'wp-toolkit'];
$filterCallback = function ($item) use ($whiteList) {
    // filter everything sold via go.plesk.com, except docker and wp-toolkit
    return (0 === strpos($item->buy_url, 'https://go.plesk.com') && !in_array($item->code, $whiteList))
        ? null
        : $item;
};

$data = json_decode(file_get_contents('https://ext.plesk.com' . $_SERVER['PATH_INFO'] . (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '')));

if (preg_match('|^/api/v\d+/packages(\?.*)?$|', $_SERVER['PATH_INFO'])) {
    $data = array_values(array_filter($data, $filterCallback));
}

if (preg_match('|^/api/v\d+/categories(\?.*)?$|', $_SERVER['PATH_INFO'])) {
    $packagesUrl = str_replace('categories', 'packages', $_SERVER['PATH_INFO']);
    $packagesWhitelist = array_map(
        function ($item) {
            return $item->code;
        },
        array_filter((array)json_decode(file_get_contents($packagesUrl)), $filterCallback)
    );
    echo print_r($packagesWhitelist, 1);
    foreach ($data as $category) {
        if (!empty($category->top_packages)) {
            $category->top_packages = array_values(array_filter($category->top_packages, function ($item) use ($packagesWhitelist) {
                return in_array($item->code, $packagesWhitelist)
                    ? $item
                    : null;
            }));
        }
    }
}

header('Content-Type: application/json');
echo json_encode($data);
