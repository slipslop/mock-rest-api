<?php 

class Mock_Person{
    
    private $requiredFields = ['name', 'email'];

    function __construct( array $attr ){
        $this->id = uniqid();
        $this->name = $attr['name'];
        $this->email = $attr['email'];
        $this->created = date('Y-m-d H:i:s');
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

    public static function getOne(string $givenId) {

        $string = file_get_contents("../Data/person.json");
        
        $json_a = json_decode($string, true);

        foreach( $json_a as $k => $value ) {
            if( $value['id'] == $givenId ) {
                return $value;
            }
        }
      
        return false;

    }

}

?>