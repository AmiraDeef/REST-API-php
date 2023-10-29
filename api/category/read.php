<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once("../../config/Database.php");
include_once("../../Models/Category.php");

//db cnnection

$database = new Database();
$db = $database->connect();

//instantiate blog category object
$category = new Category($db);

// category query
$result = $category->read();

//get num of post rows
$numRows = $result->rowCount();
//CHECK if there are categorys 
if ($numRows > 0) {
    $categoriesArr = array();
    $categoriesArr['data'] = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $category_item = array(
            'id' => $id,
            'name' => $name,

        );
        //push all
        array_push($categoriesArr['data'], $category_item);

        //turn it to json
        echo json_encode($categoriesArr);
    }
} else {
    //no categories 
    echo json_encode(array('message' => 'no categories found'));
}
