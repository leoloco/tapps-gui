<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        http_response_code(200);
        $foo = file_get_contents("php://input");
        $data = var_dump(json_decode($foo, true));
        $out = array_values($data);
        //echo print_r($data);
        header('Content-type: application/json');
        echo json_encode($out);
}    

?>