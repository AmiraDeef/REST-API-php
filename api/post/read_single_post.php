<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once("../../config/Database.php");
include_once("../../Models/Post.php");

//db cnnection

$database = new Database();
$db = $database->connect();

//instantiate blog post object
$post = new Post($db);

//get id 
$post->id = isset($_GET["id"]) ? $_GET["id"] : die();

//get a post
$post->read_single_post();

//put on array
$postArr = array(

    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->body,
    'author' => $post->author,
    'category_id' => $post->category_id,
    'category_name' => $post->category_name

);
//to json
print_r(json_encode($postArr));
