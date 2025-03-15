<?php
class Model {
    private static $db;
    public function __construct() {        
        self::$db = new PDO("mysql:host=localhost:3306;dbname=wishtransfert", "root");
    }

    public static function find($table, $params = [], $limit = 0) {
        new self();
        if (empty($params)) {
            $stmt = self::$db->prepare("SELECT * FROM $table");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $query = "SELECT * FROM $table WHERE ";
        $keys = [];
        $values = [];
        
        foreach($params as $key => $value) {
            $keys[] = "$key = ?";
            $values[] = $value;
        }
        
        $query .= implode(' AND ', $keys);
        
        
        if($limit !== 0){
            $query." LIMIT $limit";
        }

        $stmt = self::$db->prepare($query);
        $stmt->execute($values);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function insert($table, $params = []){
        new self();

        if (empty($params)) {
            throw new Exception("No data to insert");
        }

        $query = "INSERT INTO $table(";
        $columns = [];
        $values = [];
        foreach($params as $key => $value) {
            $columns[] = $key;
            $values[] = $value;
        }
        
        $query .= implode(', ', $columns);
        $query .= ") VALUES (";
        $query .= implode(', ', array_fill(0, count($values), '?'));
        $query .= ")";
        $stmt = self::$db->prepare($query);
        $stmt->execute($values);
        return true;
    }

    public static function update($table, $newValueParams = [], $whereParams = []){
        new self();
        if (empty($newValueParams)) {
            throw new Exception("No data to update");
        }

        if (empty($whereParams)) {
            throw new Exception("No condition to update");
        }

        $query = "UPDATE $table SET ";
        
        $newValues = [];
        $columns = [];
        foreach($newValueParams as $key => $value) {
            $columns[] = "$key = ? ";
            $newValues[] = $value;
        }
        $query .= implode(", ", $columns);
        
        $query .= " WHERE ";
        $whereColumns = [];
        $whereValues = [];
        foreach($whereParams as $key => $value) {
            $whereColumns[] = "$key = ? ";
            $whereValues[] = $value;
        }
        $query .= implode(" AND ", $whereColumns);
        
        $values = array_merge($newValues, $whereValues);
        $stmt = self::$db->prepare($query);
        $stmt->execute($values);
        
        return true;
    }

    public static function delete($table, $params = []){
        new self();
        $query = "DELETE FROM $table WHERE ";
        $columns = [];
        $values = [];
        foreach($params as $key => $value) {
            $columns[] = "$key = ? ";
            $values[] = $value;
        }
        $query .= implode(" AND ", $columns);
        $stmt = self::$db->prepare($query);
        $stmt->execute($values);
        
        return true;
    }
}