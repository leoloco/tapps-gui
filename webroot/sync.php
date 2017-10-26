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
        $local_data = array();
        $local_app_list = array();
  
        //Getting posted JSON string 
        $json = file_get_contents("php://input");
        //Decoding JSON string to PHP array
        $remote_app_list = json_decode($json, true);
        
        //Connecting to db
        $pdo = new PDO('mysql:host=localhost;dbname=tapps_db;charset=utf8mb4', 'root', 'data123$');
        //Building querry
        $sth = $pdo->prepare('SELECT * FROM ownerships WHERE device_id = :device_id');
        //Editing parameters
        $sth->bindParam(':device_id', $remote_app_list['device_id'], PDO::PARAM_INT);
        //X ecute query
        $sth->execute();  
        //Putting results in array
        while ($row = $sth->fetch()){
            array_push($local_data, $row['tapp_id']);
        }
        
        //Getting full data of the app
        foreach ($local_data as $tpid){
            //Building querry
            $sth = $pdo->prepare('SELECT tpid, cdn_uri, cdn_login, cdn_password FROM tapps WHERE id = :tpid');
            //Editing parameters
            $sth->bindParam(':tpid', $tpid, PDO::PARAM_INT);
            //X ecute query
            $sth->execute();
            //Putting results in array
            while ($row = $sth->fetch()){
                array_push($local_app_list, ['id' => $row['tpid'],'cdn_uri' => $row['cdn_uri'],'cdn_login' => $row['cdn_login'],'cdn_password' => $row['cdn_password']]);
            }
        }
        
        header('Content-type: application/json');
        echo print_r($remote_app_list);
}    

?>