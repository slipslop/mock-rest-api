<?php

require_once('./Handler/PersonHandler.php');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$id = getIdFromUriIfSet();
$method = $_SERVER['REQUEST_METHOD'];
$handler = new PersonHandler($method, $id);
$response = $handler->process();

echo( $response );

function getIdFromUriIfSet() : ?string {

    $uri = parse_url( $_SERVER['PATH_INFO'], PHP_URL_PATH );

    $uriParts = explode('/', $uri);
    
    $id = null;
    
    if( isset($uriParts[1]) ) {
        $id = $uriParts[1];
    }
    // if( isset($uriParts[7]) ) {
    //     $id = $uriParts[7];
    // }

    return $id;

}

?>