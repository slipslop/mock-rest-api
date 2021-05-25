<?php
header('Content-type: application/json');

http_response_code(200);

$date = new DateTime();

$mockup = [
    'id'        => uniqid(),
    'name'      => 'Foo Bar',
    'email'     => 'foo@bar.com',
    'created'   => $date->format('Y-m-d H:i:s'),
];

echo( json_encode( $mockup ) );

?>