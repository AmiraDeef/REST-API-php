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

//blog post query
$result = $post->read();

//get num of post rows
$numRows = $result->rowCount();
//CHECK if there are posts 
if ($numRows > 0) {
    $postsArr = array();
    $postsArr['data'] = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name,

        );
        //push all
        array_push($postsArr['data'], $post_item);

        //turn it to json
        echo json_encode($postsArr);
    }
} else {
    //no post 
    echo json_encode(array('message' => 'no posts found'));
}
