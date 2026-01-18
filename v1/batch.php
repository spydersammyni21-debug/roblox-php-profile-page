<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/core.php");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $inputData = file_get_contents('php://input');
    $data = json_decode($inputData, true);

    $requestId = null;
    $userId = null;
    $groupId = 8433497; // fixed groupId

    foreach ($data as $item) {
        if ($item['type'] == 'AvatarHeadShot') {
            $requestId = $item['requestId'];
            $userId = $item['targetId'];
            break;
        }
    }

    if ($userId) {
        $profileuserid = 447449877;

        foreach ($data as &$item) {
            if (isset($item['targetId']) && $item['targetId'] == $userId) {
                $item['targetId'] = $profileuserid;
            }
        }

        $inputData = json_encode($data);
        die(cURLPOSTData("https://thumbnails.roblox.com/v1/batch", $inputData));
    } else {
        // Replace any GroupIcon targetId with fixed $groupId
        foreach ($data as &$item) {
            if (isset($item['type']) && $item['type'] === 'GroupIcon') {
                $item['targetId'] = $groupId;
            }
        }

        $inputData = json_encode($data);
        die(cURLPOSTData("https://thumbnails.roblox.com/v1/batch", $inputData));
    }
} else {
    http_response_code(405);
    die(json_encode(["error" => "Method Not Allowed"]));
}
