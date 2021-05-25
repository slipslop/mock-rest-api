<?php
require_once('../Handler/PersonHandler.php');

header('Content-type: application/json');

$id = getIdFromUriIfSet();
$method = $_SERVER['REQUEST_METHOD'];
$handler = new PersonHandler($method, $id);
$response = $handler->process();

echo( $response );

function getIdFromUriIfSet() : ?string {

    $uri = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );

    $uriParts = explode('/', $uri);
    
    $id = null;
    
    if( isset($uriParts[3]) ) {
        $id = $uriParts[3];
    }

    return $id;

}

?>