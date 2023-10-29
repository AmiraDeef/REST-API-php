<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Method:DELETE");
header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Method,Authorization,X-Requested-Width");


include_once("../../config/Database.php");
include_once("../../Models/Post.php");

//db cnnection
$database = new Database();
$db = $database->connect();

//instantiate blog post object
$post = new Post($db);

//get raw posted data 
$data = json_decode(file_get_contents("php://input"));

$post->id = $data->id;

//delete post 
if ($post->delete()) {
    echo json_encode(array("status" => "success", "message" => "post has deleted"));
} else {
    echo json_encode(array("status" => "error", "message" => "there are erro making post not deleted"));
}
