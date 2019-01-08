<?php

$request_method=$_SERVER["REQUEST_METHOD"];

switch($request_method)
{
    case 'GET':
        // Retrive data
        if(!empty($_GET["product_id"]))
        {
            $product_id=intval($_GET["product_id"]);
            get_data($product_id);
        }
        else
        {
            get_data();
        }
        break;
    case 'POST':
        // Insert data
        insert_data();
        break;
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_data($product_id=0)
{
    $response=array();

    header('Content-Typee: application/json');
    header('Owner-Name: Anko');

    $response['UA'] = $_SERVER["HTTP_USER_AGENT"];
    echo json_encode($response);
}

function insert_data()
{

//    global $connection;
//    $product_name=$_POST["product_name"];
//    $price=$_POST["price"];
//    $quantity=$_POST["quantity"];
//    $seller=$_POST["seller"];
//    $query="INSERT INTO products SET product_name='{$product_name}', price={$price}, quantity={$quantity}, seller='{$seller}'";
    if(false)
    {
        $response=array(
            'status' => 1,
            'status_message' =>'Product Added Successfully.'
        );
    }
    else
    {
        $response=array(
            'status' => 0,
            'status_message' =>'Product Addition Failed.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

