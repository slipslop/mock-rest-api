<?php

require_once('../Mock/Person.php');

class PersonHandler {

    function __construct(string $requestMethod, ?string $id){
        
        $this->requestMethod = $requestMethod;
        $this->id = $id;

    }

    public function process(){

        switch( $this->requestMethod ) {

            case 'GET':
                if( $this->id ) {
                    $response = Mock_Person::getOne($this->id);
                } else {
                    $response = Mock_Person::getAll();
                }
                break;
            
            case 'POST':
                $response = $this->createNewPerson($_POST);
                break;

            case 'PUT':
                $response = $this->updatePerson();
                break;

        }

        return json_encode( $response );

    }

    public function createNewPerson(array $data){

        $person = new Mock_Person( $data );

        $person->validate();

        if( isset($person->error) ) {
            http_response_code(400);
            return [
                'message'   => 'Failed to create person',
                'missing'   => $person->error
            ];
        }

        http_response_code(201);
        return [
            'message'   => 'Successfully created a new person',
            'id'        => $person->id,
            'timestamp' => time(),
        ];

    }

    public function updatePerson() {



    }

}

?>