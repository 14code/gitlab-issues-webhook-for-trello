<?php
require_once("vendor/autoload.php");
require_once("config.php");

use Trello\Client;

//Get headers
$data = [];
$git_header = $_SERVER['HTTP_X_GITLAB_EVENT'] || $_SERVER['HTTPS_X_GITLAB_EVENT'];

//If it's not a git hook - exit
if (!$git_header) {
    return false;
}

//Read input data
$data = json_decode(file_get_contents('php://input'), true);
$issue = $data["object_attributes"];

//If it is open or exit
if($issue["action"] !== "open"){
    return false;
}

//Create new Trello Api Client
$client = new Client();
$client->authenticate($config["trello"]["key"], $config["trello"]["token"], Client::AUTH_URL_CLIENT_ID);

//Load Trello board
$board_params = [
    "filter" => "open",
    "lists" => "open"
];
$boards = $client->api('member')->boards()->all('me', $board_params);

//Find our board
$issue_board = false;
foreach($boards as $board){
    if(strtolower($board["name"]) === strtolower($config["trello"]["board_name"]) || $board["id"] === $config["trello"]["board_id"]){
        $issue_board = $board;
        break;
    }
}

//Find our list
$list_id = false;
if($issue_board){
    foreach($issue_board["lists"] as $list){
        if(!$list["closed"] && strtolower($list["name"]) === strtolower($config["trello"]["list_name"])){
            $list_id = $list["id"];
            break;
        }
    }
}else{
    return false;
}

//Create card
if($list_id){
    $card_style = $config["card_formats"][$config["card_name"]];
    $card_params = [
        "name" => $card_style[0].$issue["iid"].$card_style[1].$issue["title"],
        "desc" => $issue["description"],
        "idList" => $list_id
    ];
    $client->api('cards')->create($card_params);
}