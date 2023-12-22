<?php

include 'Model/UserModel.php';

if (!class_exists('MessagesError')) {
    include 'util/MessagesError.php';
}
if (!class_exists('MessagesSuccess')) {
    include 'util/MessagesSuccess.php';
}

class UserController {

    private $requestData;
    private $messageError;
    private $model;

    public function __construct() {
        $this->requestData = json_decode(file_get_contents('php://input'), true);
        $this->messageError = new MessagesError();
        $this->model = new UserModel();
    }

    public function getUsersByIDController($id) {
        $data = $this->model;
        
        $data->getUsersByID($id);
        
        return $data;
    }

    public function getUsersController() {
        $data = $this->model;
    
        $data->getUsers();
    
        if ($data) {
            $usersArray = array();
    
            foreach ($data as $user) {
                $jsonString = json_encode($user);
                $jsonString = str_replace('\\', '', $jsonString);
                $usersArray[] = json_decode($jsonString, true);
            }
    
            return $usersArray;
        } 
        
    }
    
    public function createUserController() {
        $data = $this->model;
    
        $name = isset($this->requestData["name"]) ? $this->requestData["name"] : null;
        $email = isset($this->requestData["email"]) ? $this->requestData["email"] : null;
        $date_of_birth = isset($this->requestData["date_of_birth"]) ? $this->requestData["date_of_birth"] : null;
        $contact_phone = isset($this->requestData["contact_phone"]) ? $this->requestData["contact_phone"] : null;
        $occupation = isset($this->requestData["occupation"]) ? $this->requestData["occupation"] : null;
        $contact_cellphone = isset($this->requestData["contact_cellphone"]) ? $this->requestData["contact_cellphone"] : null;
    
        if (empty($name) || empty($email) || empty($contact_cellphone)) {
            $this->messageError->requiredFields();
        }
        else{
            $data->createUser(
                $name,
                $email,
                $date_of_birth,
                $contact_phone,
                $occupation,
                $contact_cellphone
            );
        }
            
    }
    
    public function editUserByIDController(int $id) {
        $data = $this->model;
        
        $name = isset($this->requestData["name"]) ? $this->requestData["name"] : null;
        $email = isset($this->requestData["email"]) ? $this->requestData["email"] : null;
        $date_of_birth = isset($this->requestData["date_of_birth"]) ? $this->requestData["date_of_birth"] : null;
        $contact_cellphone = isset($this->requestData["contact_cellphone"]) ? $this->requestData["contact_cellphone"] : null;
        
        $data->editUserByID(
            $id, 
            $name, 
            $email, 
            $date_of_birth, 
            $contact_cellphone
        );
    
    }
    
    public function deleteUserByIDController(int $id) {
        $data = $this->model;
        $data->deleteUserByID($id);
    }

}



