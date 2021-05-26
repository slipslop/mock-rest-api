<?php 

require_once('../Resource.php');

class Mock_Person extends Resource {
    
    protected $fields = [
        'id'        => [
            'required'  => true,
            'type'      => 'id',
        ],
        'name'      => [
            'required'  => true,
            'type'      => 'string',
        ],
        'email'     => [
            'required'  => true,
            'type'      => 'string',
        ], 
        'created'   => [
            'required'  => true,
            'type'      => 'datetime',
        ], 
        'updated'   => [
            'required'  => false,
            'type'      => 'datetime',
        ],
    ];

    public static function getAll() : ?array {
        
        $string = file_get_contents("../Data/person.json");
        
        $json_a = json_decode($string, true);

        return $json_a;

    }

    public static function getOne(string $givenId) {

        $person = static::getPersonByIdFromPersonsCollection($givenId);

        if( !$person ) {
            return false;
        }

        $personObj = new Mock_Person();
        $personObj->set($person);
       
        return $personObj;
        
    }

    public function updateData(array $data) : Mock_Person {
        var_Dump($data);
        $this->set($data);
        $this->updated = date('Y-m-d H:i:s');
        $this->validate();

        return $this;

    }

    private static function getPersonByIdFromPersonsCollection(string $givenId) {

        $collection = file_get_contents("../Data/person.json");
        
        $assoc = true;

        $personsAsArray = json_decode($collection, $assoc);
        
        foreach( $personsAsArray as $person ) {

            if( $person['id'] == $givenId ) {
                return $person;
            }
            
        }

        return false;

    }

}

?>