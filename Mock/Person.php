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
                return true;
            }
           
            if( !$this->$method() ) {
                $this->error = $field;
                return true;
            }

        }

        return false;

    }

    public static function getAll() : ?array {

        $result = [];

        $personsCount = 4;

        for( $i = 0; $i < $personsCount; $i++ ) {
            
        }
        
        $personA = new static( ['name' => 'foo bar', 'email' => 'foo@bar.com'] );
        $personB = new static( ['name' => 'foo bar2', 'email' => 'foo2@bar.com'] );

        $result[] = $personA;
        $result[] = $personB;

        return $result;

    }

}

?>