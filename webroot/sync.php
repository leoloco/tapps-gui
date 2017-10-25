<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo "ok";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        http_response_code(200);
        $foo = file_get_contents("php://input");
        header('Content-type: application/json');
        echo json_encode(var_dump(json_decode($foo, true)));
}    

?>