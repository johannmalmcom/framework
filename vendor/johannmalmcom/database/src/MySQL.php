<?php

namespace Database;

use PDO;

class MySQL {
    
    private $server;
    private $username;
    private $password;
    private $database;
    private $result = [];
    private $error = null;
    
    private function execute($sql, $data=[]) {
        $servername = $this->server;
        $username = $this->username;
        $password = $this->password;
        $database = $this->database;

        if (
            isset($servername) &&
            isset($username) &&
            isset($password) &&
            isset($database)
        ) {
            try {
                $connection = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
                // set the PDO error mode to exception
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $statement = $connection->prepare($sql);
                $statement->execute($data);
                
                if (
                    strpos(strtolower($sql), "select") !== false || 
                    strpos(strtolower($sql), "describe") !== false || 
                    strpos(strtolower($sql), "show") !== false
                ) {
                    $this->result = $statement->fetchAll(PDO::FETCH_CLASS);
                }
            } catch(PDOException $e) {
                $this->error = $e->getMessage();
            }
        } else {
            $this->error = "You need to specify connection details.";
        }
    }
    
    // Connection
    
    public function setServer($server) {
        $this->server = $server;
    }
    
    public function setUsername($username) {
        $this->username = $username;
    }
    
    public function setPassword($password) {
        $this->password = $password;
    }
    
    public function setDatabase($database) {
        $this->database = $database;
    }
    
    // Response
    
    public function getResult() {
        return $this->result;
    }
    
    public function getError() {
        return $this->error;
    }
    
    // Data types
    
    public function typeId() {
        return [
            "name" => "id",
            "type" => "int",
            "characters" => 255,
            "extra" => "auto_increment primary key"
        ];
    }
    
    public function typeNumber($name, $characters=255) {
        return [
            "name" => $name,
            "type" => "int",
            "characters" => $characters
        ];
    }
    
    public function typeString($name, $characters=250) {
        return [
            "name" => $name,
            "type" => "varchar",
            "characters" => $characters
        ];
    }
    
    public function typeOption($name, $labels) {
        return [
            "name" => $name,
            "type" => "set",
            "characters" => $labels
        ];
    }
    
    public function typeText($name) {
        return [
            "name" => $name,
            "type" => "text"
        ];
    }
    
    public function typeDatetime($name) {
        return [
            "name" => $name,
            "type" => "datetime"
        ];
    }
    
    public function typeCreatedAt() {
        return [
            "name" => "created_at",
            "type" => "datetime",
            "extra" => "default current_timestamp()"
        ];
    }
    
    public function typeUpdatedAt() {
        return [
            "name" => "updated_at",
            "type" => "datetime",
            "extra" => "default current_timestamp() on update current_timestamp()"
        ];
    }
    
    // Queries
    
    public function createTable($name, $types) {
        if ($name != "" && count($types) > 0) {
            
            $types = array_merge([
                $this->typeId(),
                $this->typeCreatedAt(),
                $this->typeUpdatedAt()
            ], $types);
            
            $columns = "";
            foreach($types as $type) {
                $characters = "";
                
                if (isset($type["characters"])) {
                    $characters = "(".$type["characters"].")";
                }
                
                $extra = "";
                
                if (isset($type["extra"])) {
                    $extra = " ".$type["extra"];
                }
                
                $columns .= $type["name"]." ".$type["type"].$characters.$extra.", ";
            }
            $columns = trim($columns, ", ");
            
            $this->execute("CREATE TABLE IF NOT EXISTS $name ($columns);");
        }
    }
    
    public function insertInto($name, $data) {
        $columns = "";
        $values = "";
        foreach($data as $key => $value) {
            $columns .= $key.", ";
            $values .= ":".$key.", ";
        }
        $columns = trim($columns, ", ");
        $values = trim($values, ", ");
        
        $this->execute("INSERT INTO $name ($columns) VALUES ($values);", $data);
    }
    
    public function selectFrom($name, $condition=[]) {
        $conditions = "";
        
        if (count($condition) > 0) {
            $conditions = " WHERE ";
            foreach($condition as $key => $value) {
                $conditions .= $key." = :".$key." && ";
            }
            $conditions = trim($conditions, " && ");
        }
        
        $this->execute("SELECT * FROM $name $conditions;", $condition);
    }
    
    public function searchFrom($name, $condition=[]) {
        $conditions = "";
        
        if (count($condition) > 0) {
            $conditions = " WHERE ";
            foreach($condition as $key => $value) {
                $conditions .= $key." LIKE :".$key." && ";
                $condition[$key] = "%".$value."%";
            }
            $conditions = trim($conditions, " && ");
        }
        
        $this->execute("SELECT * FROM $name $conditions;", $condition);
    }
    
    public function update($name, $data, $condition=[]) {
        $sets = " SET ";
        
        if (count($data) > 0) {
            foreach($data as $key => $value) {
                $sets .= $key." = :s".$key.", ";
                unset($data[$key]);
                $data["s".$key] = $value;
            }
            $sets = trim($sets, ", ");
        }
        
        $conditions = "";
        
        if (count($condition) > 0) {
            $conditions = " WHERE ";
            foreach($condition as $key => $value) {
                $conditions .= $key." = :w".$key." && ";
                unset($condition[$key]);
                $condition["w".$key] = $value;
            }
            $conditions = trim($conditions, " && ");
        }
        
        $this->execute("UPDATE $name $sets $conditions;", array_merge($data, $condition));
    }
    
    public function deleteFrom($name, $id) {
        $this->execute("DELETE FROM $name WHERE id = :id;", [
            "id" => $id
        ]);
    }
    
}

?>