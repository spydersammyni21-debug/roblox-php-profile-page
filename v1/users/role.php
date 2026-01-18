<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/core.php");
header('Content-Type: application/json; charset=utf-8');

if($_SERVER['REQUEST_METHOD'] == "GET"){
    die(cURL("https://groups.roblox.com/v1/users/447449877/groups/primary/role"));
}else{
    http_response_code(405);
    die(json_encode(array("errors" => array(array("code" => 405, "message" => "The requested resource does not support http method '" . $_SERVER['REQUEST_METHOD'] . "'.")))));
}
