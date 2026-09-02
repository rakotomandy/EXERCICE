<?php

// creation table database et deletion table database
class Database
{
    private $db;

    public function __construct()
    {
        $this->db = new Query();
    }

    public function index()
    {
        $this->createTable('users', [
            'id' => 'INT(11) AUTO_INCREMENT PRIMARY KEY',
            'username' => 'VARCHAR(50) NOT NULL',
            'email' => 'VARCHAR(100) NOT NULL',
            'password' => 'VARCHAR(255) NOT NULL',
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);

        echo 'Users table created successfully';
    }

    public function createTable(string $table, array $columns)
    {
        $cols = [];
        foreach ($columns as $column => $type) {
            $cols[] = "$column $type";
        }
        $colsString = implode(', ', $cols);
        return $this->db->query("CREATE TABLE IF NOT EXISTS $table ($colsString)")->execute();
    }

    public function dropTable(string $table)
    {
        return $this->db->query("DROP TABLE IF EXISTS $table")->execute();
    }
}