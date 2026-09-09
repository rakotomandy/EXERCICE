<?php

class Query
{

    private static $hostname,
        $username,
        $password,
        $database,
        $connection;
    private $query;

    public static function connect($hostname, $username, $password, $database)
    {
        self::$hostname = $hostname;
        self::$username = $username;
        self::$password = $password;
        self::$database = $database;
    }

    public function __construct()
    {
        self::$connection = new PDO("mysql:host=" . self::$hostname . ";dbname=" . self::$database, self::$username, self::$password);
    }

    // public function getAll($table){
    //     $this->query = self::$connection->prepare("SELECT * FROM $table");
    //     $this->query->execute();
    //     return $this->query->fetchAll(PDO::FETCH_ASSOC);
    // }
    public function getAll($table, $limit = null, $offset = null)
    {
        if ($limit !== null && $offset !== null) {
            $this->query = self::$connection->prepare("SELECT * FROM $table LIMIT :limit OFFSET :offset");
            $this->query->bindParam(':limit', $limit, PDO::PARAM_INT);
            $this->query->bindParam(':offset', $offset, PDO::PARAM_INT);
        } elseif ($limit !== null) {
            $this->query = self::$connection->prepare("SELECT * FROM $table LIMIT :limit");
            $this->query->bindParam(':limit', $limit, PDO::PARAM_INT);
        } else {
            $this->query = self::$connection->prepare("SELECT * FROM $table");
        }
        $this->query->execute();
        return $this->query->fetchAll(PDO::FETCH_OBJ);
    }

    // get one row from table
    // ex: getOne('users', ['id' => 1])
    public function getOne($table, $where = [])
    {
        if (count($where) === 0) {
            $this->query = self::$connection->prepare("SELECT * FROM $table");
            $this->query->execute();
            return $this->query->fetch(PDO::FETCH_OBJ);
        } elseif (count($where) === 1) {
            $key = array_keys($where)[0];
            $value = array_values($where)[0];
            $this->query = self::$connection->prepare("SELECT * FROM $table WHERE $key = ?");
            $this->query->execute([$value]);
            return $this->query->fetch(PDO::FETCH_OBJ);
        } else {
            $whereClause = implode(" AND ", array_map(function ($key) {
                return "$key = ?";
            }, array_keys($where)));
            $this->query = self::$connection->prepare("SELECT * FROM $table WHERE $whereClause");
            $this->query->execute(array_values($where));
            return $this->query->fetch(PDO::FETCH_OBJ);
        }
    }

    // insert data into table
    // ex: insert('users', ['username' => 'john', 'email' => 'john@example.com'])
    public function insert($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        $this->query = self::$connection->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");
        return $this->query->execute(array_values($data));
    }

    // update data in table
    // ex:update('users', ['username' => 'new_username'], 'id = 1');
    public function update($table, $data, $where)
    {
        $set = implode(", ", array_map(function ($key) {
            return "$key = ?";
        }, array_keys($data)));

        $this->query = self::$connection->prepare("UPDATE $table SET $set WHERE $where");
        return $this->query->execute(array_values($data));;
    }

    // delete data from table
    // ex: delete('users', 'id = 1');
    public function delete($table, $where = [])
    {
        if (count($where) === 0) {
            $this->query = self::$connection->prepare("DELETE FROM $table");
            return $this->query->execute();
        } else {
            $whereClause = implode(" AND ", array_map(function ($key) {
                return "$key = ?";
            }, array_keys($where)));
            $this->query = self::$connection->prepare("DELETE FROM $table WHERE $whereClause");
            return $this->query->execute(array_values($where));
        }
    }
}

Query::connect('localhost', 'root', '', 'crud');
$db = new Query();
$db->insert('users', ['username' => 'john', 'email' => 'john@example.com']);
