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
                /*
                //Putting first row in array
                $local_app_list[0] = $results->fetch_array();
                //Putting all rows in array
                while ($local_app_list[$count]!==null){
                    $count++;
                    $local_app_list[$count]=$results->fetch_array();
                }
                $results->free();
                 */
                
                while(($row =  mysql_fetch_assoc($results))) {
                    $local_app_list[] = $row;
                }
                //For each app owned by the device on the tas
                foreach($local_app_list as $app_id){
                    //Getting the app tpid
                    $id = $app_id['tapp_id'];
                    $sql = "SELECT tpid, cdn_uri, cdn_login, cdn_password FROM tapps WHERE id = $id";
                    $results = $mysqli->query($sql);
                    if(!is_bool($results)){
                        $app_tpid = $results->fetch_array();
                        $results->free();
                        array_push($stack,$app_tpid);
                    }
                }
                $local_app_list = $stack;
                //Returning result
                header('Content-type: application/json');
                //Encoding array to JSON string
                echo json_encode($local_app_list);
            }
        }   
}    

?>