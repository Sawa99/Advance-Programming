<?php
class Database
{

    public $connection;
    public $statement;

    public function __construct($config, $username = 'root', $password = '')
    {
        $dsn = 'mysql:' . http_build_query($config, '', ';');
        $this->connection = new PDO($dsn, $username, $password, [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
    }

    public function get()
    {
        return $this->statement->fetchAll(); // feches all data from database
    }

    public function findOrFail()
    {
        $result = $this->statement->fetch();
        if (!$result) {
            abort();
        }
        return $result; // if it finds the item return else abort action
    }
    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query); //connects to server
        $this->statement->execute($params);
        return $this;  //returns the query results
    }
}