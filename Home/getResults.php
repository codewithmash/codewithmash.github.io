<?php

require 'vendor/autoload.php'; // Include Composer autoload file
header("Content-Type: application/json");

$client = "mongodb+srv://user_me:6mF31Y0gPns9MyWZ@cluster0.fowhw.mongodb.net/yatharthOnlineClasses?retryWrites=true&w=majority&appName=Cluster0";


try{
// MongoDB connection

    // // Get input from request
    $data = json_decode(file_get_contents("php://input"));

    $rollNumber = $data->rollNumber;
    $rollCode =   $data->rollCode;
    $year = (int) $data->year;

    $ab = (int) $rollNumber;
    $bc = (int) $rollCode;

    // $rollNumber = 2025;
    // $rollCode = 29832;

    // $year =  2023;


    $client = new MongoDB\Client("mongodb+srv://user_me:6mF31Y0gPns9MyWZ@cluster0.fowhw.mongodb.net/yatharthOnlineClasses?retryWrites=true&w=majority&appName=Cluster0");
    $collection = $client->yatharthOnlineClasses->{"res_$year"}; // 'school_results' is the database name, 'results' is the collection name

    if (!$rollNumber || !$rollCode ) {
        echo json_encode(["success" => false, "message" => "Roll number and roll code are required"]);
        exit();
    }
   
    // $documents = $collection->find();

    // $data = [];
    // foreach ($documents as $document) {
    //     $data[] = json_decode(json_encode($document), true);
    // }
    // echo json_encode($data, JSON_PRETTY_PRINT);

    // // Query MongoDB for the result
    
    $query = ['roll_number' => $bc, 'roll_code' => $ab];
    $result = $collection->findOne($query);

    // echo json_encode(["success" => false, "message" => $data[0]],JSON_PRETTY_PRINT);

    // $new  = json_decode(json_encode($result), true);
    // $me = json_encode($new, JSON_PRETTY_PRINT);
    // echo json_encode(["success" => true, "result" => $me["roll_number"]]);
    

    if ($result) {

        // echo json_encode(["success" => true, "result" => "found"]);

        $new  = json_decode(json_encode($result), true);
        // $me = json_encode($new, JSON_PRETTY_PRINT);
        echo json_encode(["success" => true, "result" => $new["pdf_one"]]);
    } 

    else {
        echo json_encode(["success" => false, "message" => "Result not found"]);
    }

}

catch(Exception $e)
{

        echo json_encode(["success" => false, "message" => $e->getMessage()]);
        
} 



?>


