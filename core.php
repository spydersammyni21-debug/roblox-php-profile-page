<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR | E_PARSE);
session_start();
function cURL($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, true); 
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        "Origin: https://www.roblox.com",
        "Referer: https://www.roblox.com/",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3",
        "Accept: application/json, text/javascript, */*; q=0.01",
        "Accept-Language: en-US,en;q=0.5",
        "Connection: keep-alive"
    ]);

    $result = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $headerLen = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    $headersRaw = substr($result, 0, $headerLen);
    $body = substr($result, $headerLen);
    curl_close($curl);
    foreach (explode("\r\n", $headersRaw) as $header) {
        if (!empty($header) && strpos($header, ':') !== false) {
            header($header, true); 
        }
    }
	http_response_code($httpCode);
    return $body;
}

function getXCSRF() {
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://auth.roblox.com/v2/login",
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => "{}",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => true,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "Origin: https://www.roblox.com",
            "Referer: https://www.roblox.com/",
            "User-Agent: Mozilla/5.0"
        ]
    ]);

    $response = curl_exec($curl);
    $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    $headersRaw = substr($response, 0, $headerSize);
    curl_close($curl);

    foreach (explode("\r\n", $headersRaw) as $header) {
        if (stripos($header, 'x-csrf-token:') === 0) {
            return trim(substr($header, strlen('x-csrf-token:')));
        }
    }

    return null;
}

function cURLPOSTData($url, $post) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //curl_setopt($curl, CURLOPT_PROXY, getProxyConfig()["proxy"]);
    //curl_setopt($curl, CURLOPT_PROXYUSERPWD, getProxyConfig()["proxyPWD"]);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HEADER, true); 
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        "content-type: application/json",
        "origin: https://www.roblox.com",
        "referer: https://www.roblox.com/",
        "x-csrf-token: " . getxcsrf(),
    ]);
    $result = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $headerLen = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    $headersRaw = substr($result, 0, $headerLen);
    $body = substr($result, $headerLen);
    curl_close($curl);
    foreach (explode("\r\n", $headersRaw) as $header) {
        if (!empty($header) && strpos($header, ':') !== false) {
            header($header, true); 
        }
    }
	http_response_code($httpCode);
    return $body;
}