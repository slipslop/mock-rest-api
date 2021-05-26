<?php 

class Mock_Person{
    
    public static $fields = [
        'id'    => [
            'required'  => true,
            'type'  => 'string',
        ],
        'name' => [
            'required'  => true,
            'type'  => 'string',
        ],
        'email' => [
            'required'  => true,
            'type'  => 'string',
        ], 
        'created' => [
            'required'  => true,
            'type'  => 'string',
        ], 
        'updated'   => [
            'required'  => false,
            'type'  => 'datetime',
        ]
    ];

    public function set( array $data ) {
      
        $fields = self::$fields;

        foreach( $data as $k => $v) {

            if( !isset($fields[$k]) ) {
                $this->error = "Illegal field {$k}";
                return false;
            }

            $this->$k = $v;
        
        }

        if( !isset($this->id) ) $this->id = uniqid();
        if( !isset($this->created) ) $this->created = date('Y-m-d H:i:s');
        
        return $this;
    
    }

    public function validate(){

        if( isset($this->error) ) return $this->error;

        $fields = self::$fields;

        foreach( $fields as $fieldName => $field ) {
            
            if( !isset($field['required']) ) {
                continue;
            }

            if( $field['required'] == true ) {
                
                if( !isset($this->$fieldName) ) {
                    $this->error = $fieldName;
                }

            }
            
        }
     
        return true;

    }

    public static function getAll() : ?array {
        
        $string = file_get_contents("../Data/person.json");
        
        $json_a = json_decode($string, true);

        return $json_a;

    }

    public static function getOne(string $givenId) {

        $person = static::getCorrectPersonFromPersonsCollection($givenId);

        if( !$person ) {
            return false;
        }

        $personObj = new Mock_Person();
        $personObj->set($person);
       
        return $personObj;
        
    }

    public function updateData(array $data) : Mock_Person {
       
        $this->set($data);
        $this->updated = date('Y-m-d H:i:s');
        $this->validate();

        return $this;

    }

    private static function getCorrectPersonFromPersonsCollection(string $givenId) {

        $string = file_get_contents("../Data/person.json");
        
        $personsAsArray = json_decode($string, true);

        foreach( $personsAsArray as $person ) {

            if( $person['id'] == $givenId ) {
                return $person;
            }
            
        }

        return false;

    }

}

?>