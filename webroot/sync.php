<?php

/*
 * 
 * The following function listen for JSON POST of applist
 * It checks which apps have been bought on the TAS by the owner of the device and returns a list of CDN credentials and URL's
 * corresponding to the apps to install or to delete
 * 
 * 
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        http_response_code(200);
        $stack = array();
        $local_app_list = array();
        $count = 0;
  
        //Getting posted JSON string 
        $json = file_get_contents("php://input");
        //Decoding JSON string to PHP array
        $remote_app_list = json_decode($json, true);
        
        $db = new PDO('mysql:host=localhost;dbname=tapps_db;charset=utf8mb4', 'root', 'data123$');
        $device_id = $remote_app_list['device_id'];
        $stmt = $pdo->query('SELECT * FROM ownerships WHERE device_id = $device_id');
        while ($row = $stmt->fetch()){
            echo print_r($row);
        }
        /*
        $mysql = mysql_connect("localhost", "root", "data123$");
        mysql_select_db("tapps_db");
        if($mysql){
            $device_id = $remote_app_list['device_id'];
            $results = mysql_query("SELECT * FROM ownerships WHERE device_id = $device_id");
            while($row=mysql_fetch_assoc($results)){
                $local_app_list[] = $row; // Inside while loop
                //array_push($local_app_list,$row);
            }
            header('Content-type: application/json');
                //Encoding array to JSON string
                echo json_encode($local_app_list);
        }
        else{
            echo "error";
        }
         */
        
        /*
        //Getting the TAS applist
        $mysqli = new mysqli("localhost", "root", "data123$", "tapps_db");
        if ($mysqli->connect_errno) {
            header('Content-type: application/json');
            echo json_encode(array("error" => "mysql error"));
        }
        else{
            //Selecting app id's of the given device on the TAS
            $device_id = $remote_app_list['device_id'];
            $sql = "SELECT * FROM ownerships WHERE device_id = $device_id";
            $results = $mysqli->query($sql);
            //If the device is not found
            if($results->num_rows===0){
                echo "unknown device";
            }else{
                
                while($row=mysql_fetch_assoc($results)){
                        //$local_app_list[] = $row; // Inside while loop
                        //array_push($local_app_list,$row);
                }
                //echo print_r($new_array);
                //Returning result
                header('Content-type: application/json');
                //Encoding array to JSON string
                echo json_encode($local_app_list);
            }
        }*/ 
}    

?>