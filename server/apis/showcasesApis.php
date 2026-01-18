<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/core.php");
header('Content-Type: application/json; charset=utf-8');

if($_SERVER['REQUEST_METHOD'] == "GET"){
    $assetTypeId = $_GET['assetTypeId'] ?? '';

    if($assetTypeId == 10){
        die(cURL("https://apis.roblox.com/showcases-api/v1/users/profile/playerassets-json?assetTypeId=10&userId=5457807842"));
    } elseif($assetTypeId == 11){
        die(cURL("https://apis.roblox.com/showcases-api/v1/users/profile/playerassets-json?assetTypeId=11&userId=5457807842"));
    } else {
        http_response_code(404);
        die(json_encode(["error"=>"Invalid assetTypeId"]));
    }
}else{
    http_response_code(405);
    die(json_encode(array("errors" => array(array("code" => 405, "message" => "The requested resource does not support http method '" . $_SERVER['REQUEST_METHOD'] . "'.")))));
}
