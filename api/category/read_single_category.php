<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once("../../config/Database.php");
include_once("../../Models/category.php");

//db cnnection

$database = new Database();
$db = $database->connect();

//instantiate blog category object
$category = new category($db);

//get id 
$category->id = isset($_GET["id"]) ? $_GET["id"] : die();

//get a category
$category->read_single_category();

//put on array
$categoryArr = array(

    'id' => $category->id,
    'name' => $category->name,

);
//to json
print_r(json_encode($categoryArr));
