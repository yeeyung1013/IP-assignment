<?php

class database
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $connection;

    // Constructor to initialize connection parameters
    public function __construct($host = 'localhost', $username = 'root', $password = '', $database = 'villain')
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        $this->connect();
    }

    // Method to establish a database connection
    private function connect()
    {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        // Check the connection
        if ($this->connection->connect_error) {
            throw new Exception('Connection failed: ' . $this->connection->connect_error);
        }
    }

    // Method to get the database connection
    public function getConnection()
    {
        return $this->connection;
    }

    // Destructor to close the connection
    public function __destruct()
    {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}
