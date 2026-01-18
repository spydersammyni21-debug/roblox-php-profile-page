<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/core.php");
if($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "OPTIONS"){
    die(cURLPOSTData("https://groups.roblox.com/v1/groups/policies", file_get_contents("php://input")));
}else{
    http_response_code(400);
	header('Content-Type: application/json; charset=utf-8');
	die(json_encode(["errors" => [["code" => 1, "message" => "Group is invalid or does not exist.", "userFacingMessage" => "The community is invalid or does not exist."]]]));

}
