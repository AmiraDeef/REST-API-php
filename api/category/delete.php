<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Method:DELETE");
header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Method,Authorization,X-Requested-Width");


include_once("../../config/Database.php");
include_once("../../Models/Category.php");

//db cnnection
$database = new Database();
$db = $database->connect();

//instantiate blog category object
$category = new category($db);





//get raw categoryed data 
$data = json_decode(file_get_contents("php://input"));

$category->id = $data->id;

//delete category 
if ($category->delete()) {
    echo json_encode(array("status" => "success", "message" => "category has deleted"));
} else {
    echo json_encode(array("status" => "error", "message" => "there are erro making category not deleted"));
}
