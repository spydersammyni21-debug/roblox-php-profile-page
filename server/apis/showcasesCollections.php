<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/core.php");
header('Content-Type: application/json; charset=utf-8');

if($_SERVER['REQUEST_METHOD'] == "GET"){
    $userId = $_GET['userId'] ?? '';
    if(!$userId){
        http_response_code(400);
        die(json_encode(["error"=>"Missing userId"]));
    }
    die(cURL("https://apis.roblox.com/showcases-api/v1/users/profile/robloxcollections-json?userId=".$userId));
}else{
    http_response_code(405);
    die(json_encode(array(
        "errors" => array(
            array(
                "code" => 405,
                "message" => "The requested resource does not support http method '" . $_SERVER['REQUEST_METHOD'] . "'." 
            )
        )
    )));
}
