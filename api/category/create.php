<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Method:POST");
header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Method,Authorization,X-Requested-Width");


include_once("../../config/Database.php");
include_once("../../Models/Category.php");

//db cnnection
$database = new Database();
$db = $database->connect();

//instantiate blog category object
$category = new Category($db);

//get raw posted data 
$data = json_decode(file_get_contents("php://input"));

$category->name = $data->name;


//create category 
if ($category->create()) {
    echo json_encode(array("status" => "success", "message" => "category created"));
} else {
    echo json_encode(array("status" => "error", "message" => "Category not created"));
}
