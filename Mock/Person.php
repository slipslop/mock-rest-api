<?php 

class Mock_Person{
    
    private $requiredFields = ['name', 'email'];

    function __construct( array $attr ){
        $this->id = isset($attr['id']) ? $attr['id'] : uniqid();
        $this->name = $attr['name'];
        $this->email = $attr['email'];
        $this->created = isset($attr['created']) ? $attr['created'] : date('Y-m-d H:i:s');
    }

    public function getName() : ?string {
        return $this->name;
    }

    public function setName( string $name ){
        $this->name = $name;
    }

    public function getEmail() : ?string {
        return $this->email;
    }

    public function setEmail( string $email ){
        $this->email = $email;
    }

    public function getCreated() : DateTime {
        return new Datetime( $this->created );
    }

    public function setCreated( $date ){
        $this->created = $date;
    }

    public function validate(){

        foreach( $this->requiredFields as $field ) {
            
            $fieldUppercase = ucfirst($field);

            $method = "get{$fieldUppercase}";
           
            if( !method_exists($this, $method) ) {
                $this->error = "No getter for {$method} ";
                return false;
            }
           
            if( !$this->$method() ) {
                $this->error = $field;
                return false;
            }

        }

        return true;

    }

    public static function getAll() : ?array {
        
        $string = file_get_contents("../Data/person.json");
        
        $json_a = json_decode($string, true);

        return $json_a;

    }

    public static function getOne(string $givenId) : ?Mock_Person {

        $person = static::getCorrectPersonFromPersonsCollection($givenId);

        if( !$person ) {
            return false;
        }

        return new static($person);
        
    }

    public function updateData(array $data) : Mock_Person {

        foreach($data as $k => $v) {
            $this->$k = $v;
        }

        return $this;

    }

    private static function getCorrectPersonFromPersonsCollection(string $givenId) : ?array {

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