<?php
class Resource {

    /**
     * Set resource fields. If required field is missing, try to fill it with predefined data, such as id or datetime
     */
    public function set( array $data ) {

        foreach( $data as $key => $value) {

            if( $this->givenFieldIsIllegal($key) ) {
                $this->error = "Illegal field '{$key}'";
                return false;
            }

            $this->$key = $value;
        
        }

        //set values that are not set by their types
        
        $this->setEmptyRequiredFieldsByType();

        return $this;    

    }

    /**
     * Check that no required fields are empty.
     */
    public function validate(){

        if( isset($this->error) ) return $this->error;

        $fields = $this->fields;

        foreach( $fields as $fieldName => $field ) {

            if( $this->fieldIsRequired($field) && !isset($this->$fieldName) ) {
                
                $this->error = "Missing field '{$fieldName}'";

            }
            
        }
     
        return true;

    }

    private function setEmptyRequiredFieldsByType(){

        $fields = $this->fields;

        foreach( $fields as $fieldName => $field ){

            if( $this->fieldIsRequired($field) && !isset($this->$fieldName) ) {
 
                $this->setField($field, $fieldName);

            }

        }

    }

    private function setField($field, $fieldName) {
        switch( $field['type'] ) {
            case 'id':
                $this->$fieldName = uniqid();
                break;
            case 'datetime':
                $this->$fieldName = date('Y-m-d H:i:s');
                break;
        }
    }

    private function givenFieldIsIllegal($key){
        $fields = $this->fields;
        return !isset($fields[$key]);
    }

    private function fieldIsRequired($field){
        return isset($field['required']) && $field['required'] === true;
    }

}

?>