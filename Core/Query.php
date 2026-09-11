<?php

class Query
{

    private static $hostname,
        $username,
        $password,
        $database,
        $connection;
    private $query;

    public static function connect(string $hostname, string $username, string $password, string $database)
    {
        self::$hostname = htmlspecialchars(trim($hostname));
        self::$username = htmlspecialchars(trim($username));
        self::$password = htmlspecialchars(trim($password));
        self::$database = htmlspecialchars(trim($database));
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
    public function getAll(string $table, $limit = null, $offset = null)
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
    public function getOne(string $table, $where = [], $operator = '=')
    {
        $table = htmlspecialchars(trim($table));
        $operator = htmlspecialchars(trim($operator));
        if (count($where) === 0) {
            $this->query = self::$connection->prepare("SELECT * FROM $table");
            $this->query->execute();
            return $this->query->fetch(PDO::FETCH_OBJ);
        } elseif (count($where) === 1) {
            $key = array_keys($where)[0];
            $value = array_values($where)[0];
            $this->query = self::$connection->prepare("SELECT * FROM $table WHERE $key $operator ?");
            $this->query->execute([$value]);
            return $this->query->fetch(PDO::FETCH_OBJ);
        } else {
            $whereClause = implode(" AND ", array_map(function ($key, $operator) {
                return "$key $operator ?";
            }, array_keys($where), array_values($where)));
            $this->query = self::$connection->prepare("SELECT * FROM $table WHERE $whereClause");
            $this->query->execute(array_values($where));
            return $this->query->fetch(PDO::FETCH_OBJ);
        }
    }

    // insert data into table
    // ex: insert('users', ['username' => 'john', 'email' => 'john@example.com'])
    public function insert(string $table,array $data)
    {
        $table = htmlspecialchars(trim($table));
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        $this->query = self::$connection->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");
        return $this->query->execute(array_values($data));
    }

    // update data in table
    // ex:update('users', ['username' => 'new_username'], 'id = 1');
    public function update(string $table,array $data,array $where,$operator = '=')
    {
        $table = htmlspecialchars(trim($table));
        $operator = htmlspecialchars(trim($operator));
        $set = implode(", ", array_map(function ($key) {
            return "$key = ?";
        }, array_keys($data)));
        if(count($where) === 0){
            $this->query = self::$connection->prepare("UPDATE $table SET $set");
            return $this->query->execute(array_values($data));
        }elseif(count($where) === 1){
            $key = array_keys($where)[0];
            $value = array_values($where)[0];
            $this->query = self::$connection->prepare("UPDATE $table SET $set WHERE $key $operator ?");
            return $this->query->execute(array_merge(array_values($data), [$value]));
        }else{
            $whereClause = implode(" AND ", array_map(function ($key, $operator) {
                return "$key $operator ?";
            }, array_keys($where), array_values($where)));
            $this->query = self::$connection->prepare("UPDATE $table SET $set WHERE $whereClause");
            return $this->query->execute(array_merge(array_values($data), array_values($where)));
        }
    }

    // delete data from table
    // ex: delete('users', 'id = 1');
    public function delete( string $table, array $where = [])
    {
        $table = htmlspecialchars(trim($table));
        if (count($where) === 0) {
            $this->query = self::$connection->prepare("DELETE FROM $table");
            return $this->query->execute();
        } else {
            $whereClause = implode(" AND ", array_map(function ($key, $operator) {
                return "$key $operator ?";
            }, array_keys($where), array_values($where)));
            $this->query = self::$connection->prepare("DELETE FROM $table WHERE $whereClause");
            return $this->query->execute(array_values($where));
        }
    }

    // example of custom query
    // ex: custom('SELECT * FROM users WHERE email = ?', ['john@example.com'])
    public function custom($query, $params = [])
    {
        $this->query = self::$connection->prepare(htmlspecialchars(trim($query)));
        return $this->query->execute($params);
    }
}

Query::connect('localhost', 'root', '', 'crud');
$db = new Query();
$db->insert('users', ['username' => 'john', 'email' => 'john@example.com']);
