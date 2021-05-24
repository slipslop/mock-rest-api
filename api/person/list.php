<?php
header('Content-type: application/json');

require_once('../../Mock/Person.php');

$persons = Mock_Person::getAll();

http_response_code(200);
echo( json_encode( $persons ) );
exit();

?>