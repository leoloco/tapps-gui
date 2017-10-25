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
                while($row=mysql_fetch_assoc( $result)){
                        $new_array[] = $row; // Inside while loop
                }
                echo print_r($new_array);
                //Returning result
                header('Content-type: application/json');
                //Encoding array to JSON string
                echo json_encode($local_app_list);
            }
        }   
}    

?>