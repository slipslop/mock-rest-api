<?php
require_once('./Handler.php');
require_once('./Mock/Person.php');

class PersonHandler implements Handler {

    function __construct(string $requestMethod, ?string $id){
        
        $this->requestMethod = $requestMethod;
        $this->id = $id;

    }

    public function process(){

        switch( $this->requestMethod ) {

            case 'GET':
                if( $this->id ) {
                    $response = $this->getOnePerson();
                } else {
                    $response = $this->getAllPersons();
                }
                break;

            case 'POST':
                $response = $this->createNewPerson();
                break;

            case 'PUT':
                $response = $this->updatePerson();
                break;
            
            default:
                $response = $this->notImplementedResponse();
                break;

        }
      
        return json_encode( $response );

    }

    public function getOnePerson(){
        
        $person = Mock_Person::getOne($this->id);
        
        if( !$person ) {
            return $this->personNotFoundResponse();
        } 

        return ['person' => $person];
        
    }

    public function getAllPersons(){
        $persons = Mock_Person::getAll();
        return ['persons' => $persons];
    }

    public function createNewPerson(){

        if( $this->id ) {
            http_response_code(405);
            return;
        }

        $data = $this->readInputToArray();
        $person = new Mock_Person();
        $person->set( $data );
        $person->validate();
        
        if( isset($person->error) ) {
            http_response_code(400);
            return [
                'message'   => 'Failed to create person',
                'reason'    => $person->error
            ];
        }

        http_response_code(201);
        return [
            'message'   => 'Successfully created a new person',
            'person'    => $person,
        ];

    }

    public function updatePerson() {

        if( !$this->id ) {
            http_response_code(400);
            return [
                'message'  => 'Failed to update person',
                'reason'   => 'Id is missing',
            ];
        }

        $person = Mock_Person::getOne($this->id);
        if( !$person ) {
           return $this->personNotFoundResponse();
        }

        $putParams =  $this->readInputToArray();
        if( !$putParams ){
            http_response_code(400);
            return [
                'message'   => 'Failed to update person',
                'reason'    => 'Parameters are missing',
            ];
        }

        $person = $person->updateData($putParams);
        if( isset($person->error) ) {
            http_response_code(422);
            return [
                'message'   => 'Failed to update person',
                'reason'    => $person->error
            ];
        }

        return [
            'message'   => 'Successfully updated',
            'person'    => $person
        ];

    }

    private function readInputToArray(){
        return (Array) json_decode( file_get_contents('php://input') );
    }

    private function notImplementedResponse(){
        http_response_code(405);
        return [
            'message'   => 'Method not allowed',
        ];
    }

    private function personNotFoundResponse(){
        http_response_code(404);
        return [
            'message'  => 'Person not found',
        ];
    }

}

?>