<?php

include 'DAO/UserDAO.php';

if (!class_exists('MessagesSuccess')) {
    include 'util/MessagesSuccess.php';
}

if (!class_exists('MessagesError')) {
    include 'util/MessagesError.php';
}

class UserModel {

    private $messageError;
    private $messageSuccess;
    private $dao;

    public function __construct() {
        $this->messageError = new MessagesError();
        $this->messageSuccess = new MessagesSuccess();
        $this->dao = new UserDAO();
    }

    public function getUsersByID(int $id) {
        try{
            $obj = $this->dao->selectByID($id);

            if($obj)
                echo json_encode($obj);
            else
                return $this->messageError->userNotFound('User Not Found');
        }  
        catch(Exception $e){
            print_r($e);
        }
    }

    public function getUsers() {        
        try{
            $obj = $this->dao->selectAll();

            if($obj)
                echo json_encode($obj);
            else
                return $this->messageError->userNotFound('Users Not Found');
        }  
        catch(eeror $e){
            print_r($e);
        }     
    }
    
    public function createUser(
    string $name,
    string $email,
    string $date_of_birth,
    ?string $contact_phone,
    ?string $occupation,
    string $contact_cellphone
) {
    try {
        $obj = $this->dao->insert(
            $name,
            $email,
            $date_of_birth,
            $contact_phone,
            $occupation,
            $contact_cellphone
        );
            return $this->messageSuccess->requestSuccess('created');
            return $obj;
    } catch (Exception $e) {
        echo $e;
    }
}


    public function editUserByID(
        int $id, 
        ?string $name, 
        ?string $email, 
        ?string $date_of_birth, 
        ?int $contact_cellphone
        ) {
        try {    
            $obj = $this->dao->updateByID(
                $id, 
                $name, 
                $email, 
                $date_of_birth, 
                $contact_cellphone
            );
            $this->messageSuccess->requestSuccess('edited');
            return $obj;
    
        } catch (Exception $e) {
            echo $e;
            return false;
        }
    }

    public function deleteUserByID(int $id) {
        $obj = $this->dao->selectByID($id);
    
        if (!$obj) 
            return $this->messageError->userNotFound('User Not Found');
        else {
            $result = $this->dao->deleteByID($id);
    
            if ($result) {
                $this->messageSuccess->requestSuccess('deleted');
            } else {
                return $this->messageError->userNotFound('Error deleting user');
            }
        }
    }
    
}
?>
