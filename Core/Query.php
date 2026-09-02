<?php

// To handle pdo query, database operations and db connection and relate method with models using prepared methods and chaining
class Query
{
    // custom pdo connection
    private static $hostname, $dbname, $user, $password;
    private $query, $db, $reqType, $params;

    public static function connect(string $hostname, string $dbname, string $user, string $password)
    {
        self::$hostname = $hostname;
        self::$dbname = $dbname;
        self::$user = $user;
        self::$password = $password;
    }

    public function __construct()
    {
        $this->db = new PDO("mysql:host=" . self::$hostname . ";dbname=" . self::$dbname, self::$user, self::$password);
    }

    public function select(string $table, array $columns = ['*'])
    {
        $this->reqType = 'select';
        $cols = implode(', ', $columns);
        $this->query = "SELECT $cols FROM $table";
        return $this;
    }

    public function where(string $column, string $operator, $value)
    {
        if ($this->reqType === 'select') {
            $this->query .= " WHERE $column $operator :$column";
            $this->params[$column] = $value;
        }
        return $this;
    }

    public function get()
    {
        $stmt = $this->db->prepare($this->query);
        if (isset($this->params)) {
            foreach ($this->params as $column => $value) {
                $stmt->bindValue(":$column", $value);
            }
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(string $table, array $data)
    {
        $this->reqType = 'insert';
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $this->query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $this->params = $data;
        return $this;
    }

    public function update(string $table, array $data)
    {
        $this->reqType = 'update';
        $set = '';
        foreach ($data as $column => $value) {
            $set .= "$column = :$column, ";
        }
        $set = rtrim($set, ', ');
        $this->query = "UPDATE $table SET $set";
        $this->params = $data;
        return $this;
    }

    public function delete(string $table)
    {
        $this->reqType = 'delete';
        $this->query = "DELETE FROM $table";
        return $this;
    }

    public function execute()
    {
        $stmt = $this->db->prepare($this->query);
        if (isset($this->params)) {
            foreach ($this->params as $column => $value) {
                $stmt->bindValue(":$column", $value);
            }
        }
        return $stmt->execute();
    }

    // custom query method to execute any query with parameters
    public function query(string $query, array $params = [])
    {
        $this->reqType = 'custom';
        $this->query = $query;
        $this->params = $params;
        return $this;
    }

    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }

    public function getQuery()
    {
        return $this->query;
    }
}

Query::connect('localhost', 'crud', 'root', '');
// $db = new Query();
// select example
// $db->select('users', ['id', 'name'])->where('id', '=', 1)->get();
// insert example
// $db->insert('users', ['name' => 'John Doe', 'email' => 'john.doe@example.com'])->execute();
// update example
// $db->update('users', ['name' => 'Jane Doe'])->where('id', '=', 1)->execute();
// delete example
// $db->delete('users')->where('id', '=', 1)->execute();
// echo $db->getQuery(); // Outputs: SELECT id, name FROM users WHERE id = :id
