<?php

class UserDAO {

    private $connection;
    
    public function __construct() {

        $dbHost = "localhost";
        $dbUserName = "root";
        $dbPassword = "lv1577";
        $dbName = "register_alphacode";

        $this->connection = new mysqli($dbHost, $dbUserName, $dbPassword, $dbName);
    }

    public function selectByID(int $id) {
        $sql = "SELECT * FROM signup_user WHERE id = $id";
        $result = $this->connection->query($sql);
    
        if ($result === false) {
            throw new Exception("Erro na consulta: " . $this->connection->error);
        }
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } 
        else
            return null;
        
    }

    public function selectAll() {
        $sql = "SELECT * FROM signup_user";
        $result = $this->connection->query($sql);
    
        if ($result === false)
            throw new Exception("Erro na consulta: " . $this->connection->error);
        
        $data = array();
        
        while ($row = $result->fetch_assoc()) 
            $data[] = $row;
        
        return $data;
    }

    public function insert(
        string $name,
        string $email,
        string $date_of_birth,
        ?string $contact_phone,
        ?string $occupation,
        string $contact_cellphone
    ) {
        $sql = "INSERT INTO signup_user (
            name,
            email,
            date_of_birth,
            contact_phone,
            occupation,
            contact_cellphone
        ) VALUES (?, ?, ?, ?, ?, ?)";
    
        $stmt = $this->connection->prepare($sql);
    
        if (!$stmt)
        handleRequestError();
    
        $stmt->bind_param("ssssss", 
            $name,
            $email,
            $date_of_birth,
            $contact_phone,
            $occupation,
            $contact_cellphone
        );
    
        $stmt->execute();
        $stmt->close();
        $this->connection->close();
    }
    
    public function updateByID(
        int $id, 
        ?string $name, 
        ?string $email, 
        ?string $date_of_birth, 
        ?string $contact_cellphone
        ) {
        $setClause = "SET";
        $params = array();
    
        if ($name !== null) {
            $setClause .= " name=?,";
            $params[] = $name;
        }
    
        if ($email !== null) {
            $setClause .= " email=?,";
            $params[] = $email;
        }
    
        if ($date_of_birth !== null) {
            $setClause .= " date_of_birth=?,";
            $params[] = $date_of_birth;
        }
    
        if ($contact_cellphone !== null) {
            $setClause .= " contact_cellphone=?,";
            $params[] = $contact_cellphone;
        }
    
        $setClause = rtrim($setClause, ",");
    
        $sql = "UPDATE signup_user $setClause WHERE id=?";
        $params[] = $id;
    
        $stmt = $this->connection->prepare($sql);
    
        if (!$stmt)
        handleRequestError();

        $types = '';
        if (!empty($params)) {
            $types = str_repeat('s', count($params) - 1) . 'i';
        }
    
        $stmt->bind_param($types, ...$params);
    
        $result = $stmt->execute();
    
        if (!$result) {
            throw new Exception("Erro ao atualizar o usuário: " . $stmt->error);
        }
    
        $stmt->close();
    
        return $result;
    }
      
    public function deleteByID(int $id) {
        $sql = "DELETE FROM signup_user WHERE id = ?";
        
        $stmt = $this->connection->prepare($sql);
    
        if (!$stmt)
        handleRequestError();
    
        $stmt->bind_param("i", $id);
    
        $result = $stmt->execute();
    
        if (!$result) {
            throw new Exception("Erro ao excluir o usuário: ");
        }
    
        $stmt->close();
    
        return $result;
    }

    private function handleRequestError () {
        include 'assets/MessagesError.php';
        $message = new MessagesError();
        $message->requestError();
        exit();
    }
      
}


