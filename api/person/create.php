<?php

require_once('../../Mock/Person.php');

$person = new Mock_Person( $_POST );

$error = $person->validate();

if( $error ) {
    http_response_code(400);
    $return = [
        'message'   => 'Failed to create person',
        'missing'   => $person->error
    ];
    echo( json_encode( $return ) );
    exit;
}

http_response_code(201);

$result = [
    'message'   => 'Successfully created a new person',
    'id'        => $person->id,
    'timestamp' => time(),
];

echo( json_encode( $result ) );

?>