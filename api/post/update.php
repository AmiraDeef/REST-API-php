<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Method:PUT");
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
$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->category_id = $data->category_id;

//update post 
if ($post->update()) {
    echo json_encode(array("status" => "success", "message" => "post has updated"));
} else {
    echo json_encode(array("status" => "error", "message" => "Post not updated"));
}
