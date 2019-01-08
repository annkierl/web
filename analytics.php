<?php

// Connect to database
$host = 'mysql.phost.biz';
$db_username = 'anko_4_db';
$db_password =  'wacmuf-Potzip-vapvi2';
$db_name = 'anko';

$table = 'tracks';

$connection=mysqli_connect($host,$db_username,$db_password,$db_name);
$request_method=$_SERVER["REQUEST_METHOD"];

switch($request_method)
{
    case 'GET':
        // Retrive data
        if(!empty($_GET["user_id"])) {
            $user_id = intval($_GET["user_id"]);
            get_data($user_id);
        } else {
            get_unique_visitors();
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

function get_data($user_id=0)
{
    global $connection;
    $query = "SELECT * FROM tracks WHERE user_id=".$user_id;

    $response=array();

    $result=mysqli_query($connection, $query);

    while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $response[]=$row;
    }

    header('Content-Type: application/json');

    echo json_encode($response);
}



function get_unique_visitors() {
    global $connection;
    $query = "SELECT DISTINCT user_id FROM tracks";

    $response=array();

    $result=mysqli_query($connection, $query);

    while($row=mysqli_fetch_array($result, MYSQLI_NUM)) {
        $response[]=$row;
    }

    header('Content-Type: application/json');

    echo json_encode($response);
}



function insert_data()
{
    global $connection;

    $data_str = file_get_contents('php://input');
    $data = json_decode($data_str);

    $user_id = $_GET["user_id"];

    $data_sent_time = floor($data->data_sent_time / 1000 );

    $mouse_move = json_encode($data->mouse_move);
    $user_agent = $_SERVER["HTTP_USER_AGENT"];

    $query="INSERT INTO tracks (user_id, data_sent_time, mouse_move, user_agent) VALUES ({$user_id},FROM_UNIXTIME({$data_sent_time}), '{$mouse_move}','{$user_agent}')";

    if(mysqli_query($connection, $query))
    {
        $response=array(
            'status' => 1,
            'status_message' =>'Tracking Data Added Successfully.'
        );
    }
    else
    {
        $response=array(
            'status' => 0,
            'status_message' =>'Tracking Data Addition Failed.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Close database connection
mysqli_close($connection);
